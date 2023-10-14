<?php

namespace Skeleton\Common\Models;

/**
 * Class Queue
 */
class Queue extends \Skeleton\Common\Models\ModelBase
{
    const STATUS_NEW     = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR   = 'error';
    const STATUS_DIE     = 'die';

    protected $id;
    protected $task;
    protected $data;
    protected $created_datetime;
    protected $timing_datetime;
    protected $run_datetime;
    protected $status;
    protected $counter;
    protected $error_message;

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer|null $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param string $task
     */
    public function setTask(string $task)
    {
        $this->task = $task;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCreatedDatetime()
    {
        return $this->created_datetime;
    }

    /**
     * @param string $created_datetime
     */
    public function setCreatedDatetime(string $created_datetime)
    {
        $this->created_datetime = $created_datetime;
    }

    /**
     * @return string
     */
    public function getTimingDatetime()
    {
        return $this->timing_datetime;
    }

    /**
     * @param string $timing_datetime
     */
    public function setTimingDatetime(string $timing_datetime)
    {
        $this->timing_datetime = $timing_datetime;
    }

    /**
     * @return string
     */
    public function getRunDatetime()
    {
        return $this->run_datetime;
    }

    /**
     * @param string $run_datetime
     */
    public function setRunDatetime(string $run_datetime)
    {
        $this->run_datetime = $run_datetime;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return integer
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param integer $counter
     */
    public function setCounter(int $counter)
    {
        $this->counter = $counter;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param string $error_message
     */
    public function setErrorMessage(string $error_message)
    {
        $this->error_message = $error_message;
    }
}
