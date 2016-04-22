<?php
namespace CoreDomain\Model\Gallery;

class Album
{
    private $id;
    private $name;
    private $description;
    private $image;
    private $album;
    private $params;
    private $isDeleted = false;

    public function updateInfo($name, $description, $image, Album $album)
    {
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->album = $album;
    }
}