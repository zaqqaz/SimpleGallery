<?php
namespace CoreDomain\Model\File;

class Image extends File
{
    public $id;
    public $path;
    public $name;

    public function getUploadDir()
    {
        return 'image/';
    }

    public function getValidationGroup()
    {
        return 'image_upload';
    }
}