<?php

namespace Skeleton\Library;

/**
 * Image.
 *
 * @copyright Copyright (c) 2023 innobotics (https://innobotics.eu)
 * @author Norbert Lakatos <norbert@innobotics.eu>
 */
class Image
{
    const EXTENSION = 'jpg';

    protected $config;

    /** @var \Skeleton\Library\Helper $helper */
    protected $helper;

    /**
     * Construct
     */
    function __construct()
    {
        $this->config = \Phalcon\Di\Di::getDefault()->get('config');
        $this->helper = \Phalcon\Di\Di::getDefault()->get('helper');
    }

    /**
     * @param string $file
     * @param string $title
     * @param int $parentId
     * @param string $type
     * @return array
     */
    public function add(string $file, string $title, int $parentId, string $type)
    {
        try {
            // Check file
            if (!\is_file($file)) {
                throw new \Exception('File not found: ' . $file);
            }


            // Check title
            if (empty($title)) {
                throw new \Exception('Invalid title');
            }


            // Check type
            $types = $this->config->image->types;

            $enabledTypes[] = \Skeleton\Common\Models\Images::TYPE_TEMP;
            foreach ($types as $typeKey => $typeValue) {
                $enabledTypes[] = $typeKey;
            }

            if (!\in_array($type, $enabledTypes)) {
                throw new \Exception('Invalid type: ' . $type);
            }


            // Generate code, folder and filename
            $code = \date('Ym')
                . $this->helper->getRandomString(10);

            $dirname = '';
            for ($i = 0; $i < \strlen($code); $i++) {
                $dirname = $dirname . '/' . \substr($code, $i, 1);
            }

            $filename = $this->helper->getFriendlyName($title) . '.' . self::EXTENSION;


            // Create folder
            \mkdir($this->config->image->path . $dirname, 0777, true);


            // Save image
            $imageResize = new \Innobotics\ImageResize();

            $imageResize->setProgressive(true);
            $imageResize->setSaveOriginal(true);

            foreach ($this->config->image->size as $sizeType => $value) {
                $imageResize->setType(
                    $sizeType,
                    $value['width'],
                    $value['height']
                );
            }

            $imageResize->setSource($file);
            $imageResize->setTarget($this->config->image->path . $dirname);
            $imageResize->setFileName($filename);

            if ($imageResize->resize() != true) {
                $result = $imageResize->getResult();
                throw new \Exception('Image process (' . $result['message'] . ')');
            }


            // Count images by type and parent
            $itemCount = \Skeleton\Common\Models\Images::count([
                'conditions' => 'type = :type: AND parent_id = :parent_id:',
                'bind'       => [
                    'type'      => $type,
                    'parent_id' => $parentId
                ]
            ]);


            // Save to database
            $image = new \Skeleton\Common\Models\Images();

            $image->setType($type);
            $image->setParentId($parentId);
            $image->setCode($code);
            $image->setTitle($title);
            $image->setFilename($filename);
            $image->setDirname($dirname);
            $image->setOrderNumber($itemCount + 1);
            $image->setResized(1);
            $image->setCreatedDate(\date('Y-m-d H:i:s'));

            if ($image->save() == false) {
                $errorMessage = [];
                foreach ($image->getMessages() as $message) {
                    $errorMessage[] = $message;
                }

                throw new \Exception('Database save error: ' . \implode(', ', $errorMessage));
            }

            return [
                'status'  => 'success',
                'data'    => [
                    'code' => $code
                ],
                'message' => ''
            ];
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'data'    => [],
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete(string $code)
    {
        try {
            // Image search in database
            /** @var \Skeleton\Common\Models\Images $image */
            $image = \Skeleton\Common\Models\Images::findFirst([
                'conditions' => 'code = :code:',
                'bind'       => [
                    'code' => $code
                ]
            ]);

            if (!$image) {
                throw new \Exception(_('File not found!'));
            }

            $parentId = $image->getParentId();
            $type = $image->getType();
            $orderNumber = $image->getOrderNumber();


            // Delete original image
            $filePath = $this->config->image->path . $image->getDirname() . '/' . $image->getFilename();

            if (\is_file($filePath)) {
                \unlink($filePath);
            }


            // Delete resized images
            foreach ($this->config->image->size as $sizeKey => $sizeValue) {
                $filePath = $this->config->image->path . $image->getDirname() . '/' . $image->getFilename();
                $filePath = \str_replace(
                    '.' . self::EXTENSION,
                    '_' . $sizeKey . '.' . self::EXTENSION,
                    $filePath
                );

                if (\is_file($filePath)) {
                    \unlink($filePath);
                }
            }


            // Delete from database
            $image->delete();


            // Reorder
            /** @var \Skeleton\Common\Models\Images $item */
            foreach (\Skeleton\Common\Models\Images::find([
                'conditions' => 'parent_id = :parent_id: AND type = :type: AND order_number > :order_number:',
                'bind'       => [
                    'parent_id'    => $parentId,
                    'type'         => $type,
                    'order_number' => $orderNumber
                ]
            ]) as $item) {
                $newOrderNumber = ($item->getOrderNumber()-1);

                $item->setOrderNumber($newOrderNumber);
                $item->save();
            }


            return true;
        } catch (\Exception $e) {
            return _('Error') .  ': ' . $e->getMessage();
        }
    }

    public function getByCode(string $code)
    {
        try {
            /** @var \Skeleton\Common\Models\Images $image */
            $image = \Skeleton\Common\Models\Images::findFirst([
                'conditions' => 'code = :code:',
                'bind'       => [
                    'code' => $code
                ]
            ]);

            if (!$image) {
                throw new \Exception(_('File not found'));
            }

            $sizes = $this->config->image->size;

            $enabledSizes = [];
            foreach ($sizes as $sizeKey => $sizeValue) {
                $enabledSizes[$sizeKey] = [
                    'filepath' => $this->config->image->url . $image->getDirname() . '/' . \str_replace('.' . self::EXTENSION, '_' . $sizeKey . '.' . self::EXTENSION, $image->getFilename()),
                    'width'    => $sizeValue['width'],
                    'height'   => $sizeValue['height'],
                    'title'    => $sizeValue['title']
                ];
            }

            $exifData = \exif_read_data(
                $this->config->image->path . $image->getDirname() . '/' . $image->getFilename(),
                0,
                true
            );

            $result = [
                'code'         => $image->getCode(),
                'title'        => $image->getTitle(),
                'type'         => $image->getType(),
                'type_name'    => $this->getNameOfType($image->getType()),
                'parent_id'    => $image->getParentId(),
                'order_number' => $image->getOrderNumber(),
                'parent_title' => $this->getParentTitle($image->getParentId(), $image->getType()),
                'filename'     => $image->getFilename(),
                'filepath'     => $enabledSizes,
                'created_date' => $image->getCreatedDate(),
                'exif_data'    => $exifData
            ];

            return $result;

        } catch (\Exception $e) {
            return _('Error') . ': ' . $e->getMessage();
        }
    }

    public function getByTypeAndParentId(string $type, int $parentId)
    {
        try {
            $result = [];

            /** @var \Skeleton\Common\Models\Images $image */
            foreach (\Skeleton\Common\Models\Images::find([
                'conditions' => 'type = :type: AND parent_id = :parent_id:',
                'bind'       => [
                    'type'      => $type,
                    'parent_id' => $parentId,
                ],
                'order'      => 'order_number ASC'
            ]) as $image) {

                $sizes = $this->config->image->size;

                $enabledSizes = [];
                foreach ($sizes as $sizeKey => $sizeValue) {
                    $enabledSizes[$sizeKey] = [
                        'filepath' => $this->config->image->url . $image->getDirname() . '/' . \str_replace('.' . self::EXTENSION, '_' . $sizeKey . '.' . self::EXTENSION, $image->getFilename()),
                        'width'    => $sizeValue['width'],
                        'height'   => $sizeValue['height'],
                        'title'    => $sizeValue['title']
                    ];
                }

                $exifData = \exif_read_data(
                    $this->config->image->path . $image->getDirname() . '/' . $image->getFilename(),
                    0,
                    true
                );

                $result[] = [
                    'code'         => $image->getCode(),
                    'title'        => $image->getTitle(),
                    'type'         => $image->getType(),
                    'type_name'    => $this->getNameOfType($image->getType()),
                    'parent_id'    => $image->getParentId(),
                    'order_number' => $image->getOrderNumber(),
                    'parent_title' => $this->getParentTitle($image->getParentId(), $image->getType()),
                    'filename'     => $image->getFilename(),
                    'filepath'     => $enabledSizes,
                    'created_date' => $image->getCreatedDate(),
                    'exif_data'    => $exifData
                ];
            }

            return $result;

        } catch (\Exception $e) {
            return _('Error') . ': ' . $e->getMessage();
        }
    }

    public function list()
    {
        $images = [];

        /** @var \Skeleton\Common\Models\Images $item */
        foreach (\Skeleton\Common\Models\Images::find([
            'conditions' => 'type <> :tmp:',
            'bind'       => [
                'tmp' => \Skeleton\Common\Models\Images::TYPE_TEMP
            ],
            'order'      => 'created_date DESC'
        ]) as $item) {
            $images[$item->getCode()] = [
                'code'         => $item->getCode(),
                'title'        => $item->getTitle(),
                'type'         => $item->getType(),
                'type_name'    => $this->getNameOfType($item->getType()),
                'parent_id'    => $item->getParentId(),
                'order_number' => $item->getOrderNumber(),
                'parent_title' => $this->getParentTitle($item->getParentId(), $item->getType()),
                'filename'     => $item->getFilename(),
                'filepath'     => $this->config->image->url . $item->getDirname() . '/' . \str_replace('.' . self::EXTENSION, '_th.' . self::EXTENSION, $item->getFilename()),
                'created_date' => $item->getCreatedDate()
            ];
        }

        return $images;
    }

    private function getNameOfType(string $type)
    {
        $types = $this->config->image->types;

        $enabledTypes[\Skeleton\Common\Models\Images::TYPE_TEMP] = \Skeleton\Common\Models\Images::TYPE_TEMP_NAME;
        foreach ($types as $typeKey => $typeValue) {
            $enabledTypes[$typeKey] = $typeValue['name'];
        }

        if (!empty($enabledTypes[$type])) {
            return $enabledTypes[$type];
        }

        return '?';
    }

    private function getParentTitle(int $parentId, string $type)
    {
        return 'ID: ' . $parentId; //@todo
    }
}
