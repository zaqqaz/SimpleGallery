<?php

namespace AppBundle\Services\Managers\File;


use AppBundle\Repository\File\ImageRepository;
use CoreDomain\Exception\ValidationException;
use CoreDomain\Model\File\File;
use CoreDomain\Model\File\Image;
use CoreDomain\Repository\FileRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FileManager
{
    private $validator;
    private $imageRepository;

    public function __construct(
        ValidatorInterface $validator,
        ImageRepository $imageRepository
    )
    {
        $this->validator = $validator;
        $this->imageRepository = $imageRepository;
    }

    public function upload(UploadedFile $uploadedFile, $type)
    {
        $fileClass = $this->getFileClass($type);
        /** @var File $file */
        $file = new $fileClass($uploadedFile);

        $errors = $this->validator->validate($file, null, $file->getValidationGroup());
        if(count($errors) > 0) {
            throw new ValidationException('File validation error', $errors);
        }

        $uploadedFile->move($file->getUploadRootDir(), $file->getName());
        $repository = $this->getFileRepository($type);
        $repository->add($file);

        return $file;
    }

    /**
     * @param $type
     * @return File
     */
    private function getFileClass($type)
    {
        switch ($type) {
            case 'image':
                return Image::class;
                break;
        }
    }

    /**
     * @param $type
     * @return FileRepositoryInterface
     */
    private function getFileRepository($type)
    {
        switch ($type) {
            case 'image':
                return $this->imageRepository;
                break;
        }
    }
}