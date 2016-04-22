<?php

namespace CoreDomain\Model\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class File
{
    protected $id;
    protected $path;
    protected $originalName;
    protected $name;

    protected $file;

    public function __construct(UploadedFile $file = null)
    {
        $this->file = $file;
        $this->originalName = $file->getClientOriginalName();
        $this->name = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        $this->path = '/files/' . $this->getUploadDir();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return null
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/files/' . $this->getUploadDir();
    }

    public function setFullPath($host)
    {
        $this->path = $host . $this->path;
    }

    public abstract function getUploadDir();

    public abstract function getValidationGroup();
}