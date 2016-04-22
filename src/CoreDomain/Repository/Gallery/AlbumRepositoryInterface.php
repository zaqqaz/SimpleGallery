<?php

namespace CoreDomain\Repository\Gallery;

use CoreDomain\Model\Gallery\Album;

interface AlbumRepositoryInterface
{
    /** @return \CoreDomain\Model\Gallery\Album */
    public function findOneById($id);

    public function addAndSave(Album $album);
}