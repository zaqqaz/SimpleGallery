<?php
namespace CoreDomain\Model\Gallery;

class Photo
{
    private $id;
    private $name;
    public $album;
    public $image;
    private $description;
    private $params;
    private $isDeleted = false;

    public function updateInfo($name, $image, Album $album, $description, $isDeleted = false, $params = null)
    {
        $this->name = $name;
        $this->image = $image;
        $this->params = $params;
        $this->album = $album;
        $this->description = $description;
        $this->isDeleted = $isDeleted;
    }

}