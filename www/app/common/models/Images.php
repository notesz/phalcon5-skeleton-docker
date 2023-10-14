<?php

namespace Skeleton\Common\Models;

/**
 * Class Images
 */
class Images extends \Skeleton\Common\Models\ModelBase
{
    const TYPE_TEMP = 'tmp';
    const TYPE_TEMP_NAME = 'Temporarily file';

    protected $id;
    protected $type;
    protected $parent_id;
    protected $code;
    protected $title;
    protected $filename;
    protected $dirname;
    protected $order_number;
    protected $resized;
    protected $created_date;

    /**
     * Initialize
     */
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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return integer
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param integer $parent_id
     */
    public function setParentId(int $parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * @param string $dirname
     */
    public function setDirname(string $dirname)
    {
        $this->dirname = $dirname;
    }

    /**
     * @return integer
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * @param integer $order_number
     */
    public function setOrderNumber(int $order_number)
    {
        $this->order_number = $order_number;
    }

    /**
     * @return integer
     */
    public function getResized()
    {
        return $this->resized;
    }

    /**
     * @param integer $resized
     */
    public function setResized(int $resized)
    {
        $this->resized = $resized;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param string $created_date
     */
    public function setCreatedDate(string $created_date)
    {
        $this->created_date = $created_date;
    }
}
