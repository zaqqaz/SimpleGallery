<?php

namespace AppBundle\Services\Managers\Gallery;

use AppBundle\Repository\File\ImageRepository;
use CoreDomain\DTO\Gallery\AlbumDTO;
use CoreDomain\Model\Gallery\Album;
use CoreDomain\Repository\Gallery\AlbumRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AlbumManager
{
    private $em;

    public function __construct(
        EntityManagerInterface $em,
        AlbumRepositoryInterface $albumRepository,
        ImageRepository $imageRepository
    )
    {
        $this->em = $em;
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
    }

    public function addAlbum(AlbumDTO $albumDTO)
    {
        $this->em->beginTransaction();
        try {
            $album = new Album();
            $album->updateInfo($albumDTO->name, $albumDTO->description, $this->imageRepository->findOneById($albumDTO->image));
            $this->albumRepository->addAndSave($album);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

    }
}