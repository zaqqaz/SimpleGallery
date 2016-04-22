<?php

namespace CoreDomain\Repository;


use CoreDomain\Model\File\File;

interface FileRepositoryInterface
{
    public function add(File $media);

    public function findOneById($id);
}