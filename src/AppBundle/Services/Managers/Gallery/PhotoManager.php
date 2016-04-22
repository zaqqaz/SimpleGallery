<?php

namespace AppBundle\Services\Managers\Gallery;

use AppBundle\Repository\Gallery\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\DeserializationContext;

class PhotoManager
{
    private $em;
    private $photoRepository;

    public function __construct(
        EntityManagerInterface $em,
        PhotoRepository $photoRepository
    )
    {
        $this->em = $em;
        $this->photoRepository = $photoRepository;
    }

    public function getPhotosByDTO($params, $limit = null, $offset = null)
    {
        return $photos = $this->photoRepository->findAll();
    }
}