<?php

namespace AppBundle\Repository\Gallery;

use CoreDomain\Model\Gallery\Photo;
use CoreDomain\Repository\Gallery\PhotoRepositoryInterface;
use Doctrine\ORM\EntityManager;

class PhotoRepository implements PhotoRepositoryInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findAll() {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Photo::class, 'p')
            ->getQuery()
            ->getResult();
    }

    public function addAndSave(Photo $entity)
    {
        $this->em->persist($entity);
        $this->em->flush($entity);
    }

    public function findOneById($id)
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Photo::class, 'p')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function deleteById($id)
    {
        return $this->em->createQueryBuilder()
            ->update(Photo::class, 'p')
            ->set('p.isDeleted', true)
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByDTO(EducationRequestDTO $dto)
    {
        // TODO: Implement findAllByDTO() method.
    }
}

