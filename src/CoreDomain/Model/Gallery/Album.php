<?php
namespace CoreDomain\Model\Gallery;

class Album
{
    private $id;
    private $name;
    private $description;
    private $image;
    private $params;
    private $isDeleted = false;

    public function updateInfo($name, $description, $image)
    {
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
    }
}