<?php

namespace CoreDomain\DTO\Gallery;


class PhotoDTO
{
    public $id;
    public $name;

    public $template;

    public function getClass()
    {
        return get_called_class();
    }

    public function getDependencyFields()
    {
        return array();
    }
}