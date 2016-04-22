<?php

namespace AppBundle\Repository\Gallery;

use CoreDomain\Model\Gallery\Album;
use CoreDomain\Repository\Gallery\AlbumRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AlbumRepository implements AlbumRepositoryInterface
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findAll() {
        return $this->em->createQueryBuilder()
            ->select('al')
            ->from(Album::class, 'al')
            ->getQuery()
            ->getResult();
    }

    public function getTotalCount() {
        return $this->em->createQueryBuilder()
            ->select('count(al)')
            ->from(Album::class, 'al')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function addAndSave(Album $entity)
    {
        $this->em->persist($entity);
        $this->em->flush($entity);
    }

    public function findOneById($id)
    {
        return $this->em->createQueryBuilder()
            ->select('al')
            ->from(Album::class, 'al')
            ->where('al.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
