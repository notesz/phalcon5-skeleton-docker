<?php

namespace Skeleton\Common\Models;

/**
 * Class Files
 */
class Files extends \Skeleton\Common\Models\ModelBase
{
    protected $id;
    protected $code;
    protected $title;
    protected $filename;
    protected $dirname;
    protected $extension;
    protected $mimetype;
    protected $filesize;
    protected $created_date;

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
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * @param string $mimetype
     */
    public function setMimetype(string $mimetype)
    {
        $this->mimetype = $mimetype;
    }

    /**
     * @return string
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * @param string $filesize
     */
    public function setFilesize(string $filesize)
    {
        $this->filesize = $filesize;
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
