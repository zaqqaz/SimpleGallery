<?php

namespace AppBundle\Controller\Gallery;


use CoreDomain\DTO\Gallery\PhotoDTO;
use CoreDomain\Model\Gallery\Album;
use JMS\Serializer\DeserializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class PhotoController extends Controller
{
    /**
     * @Rest\GET("/albums/{id}/photos")
     * @Rest\View(serializerGroups="api_photo_list", statusCode=200)
     */
    public function getPhotosAction(Request $request, Album $album)
    {
        $photos = $this->get('app.repository.gallery.photo')
            ->findByAlbum($album, $request->get('limit',100), $request->get('offset', 0));
        $totalCount = $this->get('app.repository.gallery.photo')->getTotalCount()[1];
        return View::create($photos, 200, ['X-Total-Count' => $totalCount]);
    }

    /**
     * @Rest\Post("/albums/{id}/photos")
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "photoDTO",
     *     converter="fos_rest.request_body",
     *     options={
     *         "deserializationContext"={"groups"="api_photo_request"}
     *     }
     * )
     */
    public function createPhotoAction(PhotoDTO $photoDTO, Album $album)
    {
        $this
            ->get('app.repository.gallery.photo')
            ->addPhoto($photoDTO, $album);
    }

    /**
     * @Rest\Get("/photos/{id}")
     * @Rest\View(serializerGroups="api_photo_get", statusCode=200)
     */
    public function getPhotoAction($id)
    {
        return $this
            ->get('app.gallery.photo')
            ->getPhoto($id);
    }

    /**
     * @Rest\Patch("/photos/{id}")
     * @Rest\View(statusCode=200),
     * @ParamConverter(
     *     "photoRequestDTO",
     *     converter="fos_rest.request_body",
     *     options={
     *         "deserializationContext"={"groups"="api_photo_request"}
     *     }
     * )
     */
    public function updatePhotoAction(PhotoDTO $photoRequestDTO, $id)
    {
        $this
            ->get('app.gallery.photo')
            ->updatePhoto($id, $photoRequestDTO);
    }

    /**
     * @Rest\Delete("/photos/{id}")
     * @Rest\View("statusCode=204")
     */
    public function deletePhotoAction($id)
    {
        $this
            ->get('app.repository.photo')
            ->deleteById($id);
    }
}