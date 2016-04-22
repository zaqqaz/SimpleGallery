<?php

namespace CoreDomain\Repository\Gallery;
use CoreDomain\Model\Gallery\Photo;

interface PhotoRepositoryInterface
{
    public function findOneById($id);
    public function deleteById($id);
    public function addAndSave(Photo $entity);
}