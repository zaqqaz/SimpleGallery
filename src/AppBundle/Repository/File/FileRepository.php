<?php

namespace AppBundle\Repository\File;


use CoreDomain\Model\File\File;
use CoreDomain\Repository\FileRepositoryInterface;
use Doctrine\ORM\EntityManager;

abstract class FileRepository implements FileRepositoryInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function add(File $file)
    {
        $this->em->persist($file);
        $this->em->flush();
    }

    public abstract function findOneById($id);
}