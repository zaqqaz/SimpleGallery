<?php

namespace AppBundle\Repository\Gallery;

use CoreDomain\DTO\Gallery\PhotoDTO;
use CoreDomain\Model\Gallery\Album;
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

    public function findByAlbum(Album $album, $limit, $offset)
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Photo::class, 'p')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('p.album = :album')
            ->setParameter('album', $album)
            ->getQuery()
            ->getResult();
    }

    public function getTotalCount()
    {
        return $this->em->createQueryBuilder()
            ->select('count(p)')
            ->from(Photo::class, 'p')
            ->getQuery()
            ->getOneOrNullResult();
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

