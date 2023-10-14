<?php

namespace Skeleton\Library;

/**
 * Queue.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Queue
{
    const MAX_ERROR_COUNT = 5;

    protected $config;

    /**
     * Queue constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $task
     * @param array $data
     * @param string $timingDatetime
     * @return bool|int
     * @throws Exception
     */
    public function add(string $task, array $data = [], string $timingDatetime = '')
    {
        if ($timingDatetime == '') {
            $timingDatetime = \date('Y-m-d H:i:s');
        }

        $queueItem = new \Skeleton\Common\Models\Queue();

        $queueItem->setId(null);
        $queueItem->setTask($task);
        $queueItem->setData(\json_encode($data));
        $queueItem->setCreatedDatetime(\date('Y-m-d H:i:s'));
        $queueItem->setTimingDatetime($timingDatetime);
        $queueItem->setStatus(\Skeleton\Common\Models\Queue::STATUS_NEW);
        $queueItem->setCounter(0);
        $queueItem->setErrorMessage(\json_encode([]));

        if ($queueItem->save() === true) {
            return $queueItem->getId();
        }

        return false;
    }

    /**
     * Get queue items from database (and set to pending) and put them to an array.
     *
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function getItems(int $limit = 50)
    {
        $this->errorHandle();

        $queueItems = [];

        /** @var \Skeleton\Common\Models\Queue $item */
        foreach (\Skeleton\Common\Models\Queue::find([
            'conditions' => 'status = :status: AND timing_datetime < :now_datetime:',
            'bind'       => [
                'status'       => \Skeleton\Common\Models\Queue::STATUS_NEW,
                'now_datetime' => \date('Y-m-d H:i:s')
            ],
            'order'      => 'created_datetime',
            'limit'      => $limit
        ]) as $item) {
            $queueItems[$item->getId()] = $item->toArray();

            $item->setStatus(\Skeleton\Common\Models\Queue::STATUS_PENDING);
            $item->setRunDatetime(\date('Y-m-d H:i:s'));
            $item->save();
        }

        return $queueItems;
    }

    /**
     * Error handle.
     *
     * @return void
     * @throws Exception
     */
    public function errorHandle()
    {
        // Set status to "new" and set timing_datetime (counter + 5 minutes).

        /** @var \Skeleton\Common\Models\Queue $item */
        foreach (\Skeleton\Common\Models\Queue::find([
            'conditions' => 'status = :status: AND counter < :max_error_count:',
            'bind'       => [
                'status'          => \Skeleton\Common\Models\Queue::STATUS_ERROR,
                'max_error_count' => self::MAX_ERROR_COUNT
            ]
        ]) as $item) {
            $item->setStatus(\Skeleton\Common\Models\Queue::STATUS_NEW);
            $item->setTimingDatetime(
                \date('Y-m-d H:i:s', \strtotime('+' . ($item->getCounter() * 5) . ' minutes'))
            );

            $item->save();
        }


        // Set status to "error".

        foreach (\Skeleton\Common\Models\Queue::find([
            'conditions' => 'status = :status: AND counter >= :max_error_count:',
            'bind'       => [
                'status'          => \Skeleton\Common\Models\Queue::STATUS_ERROR,
                'max_error_count' => self::MAX_ERROR_COUNT
            ]
        ]) as $item) {
            $item->setStatus(\Skeleton\Common\Models\Queue::STATUS_DIE);
            $item->save();
        }
    }

    /**
     * @param integer $queueId
     * @return string
     * @throws Exception
     */
    public function process(int $queueId)
    {
        /** @var \Skeleton\Common\Models\Queue $queueItem */
        $queueItem = \Skeleton\Common\Models\Queue::findFirst([
            'conditions' => 'id = :queue_id:',
            'bind'       => [
                'queue_id' => $queueId
            ]
        ]);

        $error = '';

        if ($queueItem) {
            try {
                $className =  '\Skeleton\Queue\\' . \ucfirst(
                        \str_replace(' ', '',
                            \ucwords(
                                \str_replace('_', ' ', $queueItem->getTask())
                            )
                        )
                    );

                $process = new $className(\json_decode($queueItem->getData(), true));
                $result = $process->process();

                if ($result !== true) {
                    throw new \Exception($result);
                }

                $queueItem->setRunDatetime(\date('Y-m-d H:i:s'));
                $queueItem->setCounter($queueItem->getCounter() + 1);
                $queueItem->setStatus(\Skeleton\Common\Models\Queue::STATUS_SUCCESS);
                $queueItem->save();

            } catch (\Exception | \Throwable $e) {
                $error = $e->getMessage();

                $queueItem->setRunDatetime(\date('Y-m-d H:i:s'));
                $queueItem->setCounter($queueItem->getCounter() + 1);
                $queueItem->setStatus(\Skeleton\Common\Models\Queue::STATUS_ERROR);

                $errorMessage = \json_decode($queueItem->getErrorMessage(), true);
                $errorMessage[\date('Y-m-d H:i:s')] = $error;
                $errorMessage = \json_encode($errorMessage);

                $queueItem->setErrorMessage($errorMessage);
                $queueItem->save();

                return $error;
            }
        }

        if ($error != '') {
            return 'ERROR: ' . $error;
        }

        return 'OK';
    }
}
