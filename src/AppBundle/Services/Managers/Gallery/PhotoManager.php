<?php

namespace AppBundle\Services\Managers\Gallery;

use AppBundle\Repository\File\ImageRepository;
use AppBundle\Repository\Gallery\PhotoRepository;
use CoreDomain\DTO\Gallery\PhotoDTO;
use CoreDomain\Model\Gallery\Album;
use CoreDomain\Model\Gallery\Photo;
use Doctrine\ORM\EntityManagerInterface;

class PhotoManager
{
    private $em;
    private $photoRepository;

    public function __construct(
        EntityManagerInterface $em,
        PhotoRepository $photoRepository,
        ImageRepository $imageRepository
    )
    {
        $this->em = $em;
        $this->photoRepository = $photoRepository;
        $this->imageRepository = $imageRepository;
    }

    public function addPhoto(PhotoDTO $photoDTO, Album $album)
    {
        $this->em->beginTransaction();
        try {
            $photo = new Photo();
            $photo->updateInfo($photoDTO->name, $photoDTO->description, $this->imageRepository->findOneById($photoDTO->image), $album);
            $this->photoRepository->addAndSave($photo);
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }
}