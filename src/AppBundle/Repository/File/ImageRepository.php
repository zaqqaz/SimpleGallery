<?php

namespace AppBundle\Repository\File;


use CoreDomain\Model\File\Image;

class ImageRepository extends FileRepository
{
    public function findOneById($id)
    {
        return $this->em->createQueryBuilder()
            ->select('i')
            ->from(Image::class, 'i')
            ->where('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}