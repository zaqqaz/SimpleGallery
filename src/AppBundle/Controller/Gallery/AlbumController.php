<?php

namespace AppBundle\Controller\Gallery;

use CoreDomain\DTO\Gallery\AlbumDTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AlbumController extends Controller
{
    /**
     * @Rest\Get("/albums")
     * @Rest\View(serializerGroups={"api_album_get", "api_image_get"}, statusCode=200)
     */
    public function getAlbumsAction()
    {
        return $this->get('app.repository.gallery.album')->findAll();
    }

    /**
     * @Rest\Post("/albums")
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "albumDTO",
     *     converter="fos_rest.request_body",
     *     options={
     *         "deserializationContext"={"groups"="api_album_create"}
     *     }
     * )
     */
    public function createAlbumAction(AlbumDTO $albumDTO)
    {
        $this
            ->get('app.gallery.album')
            ->addAlbum($albumDTO)
        ;
    }
}