<?php

namespace AppBundle\Controller\Gallery;


use CoreDomain\DTO\Gallery\PhotoDTO;
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
    public function getPhotosAction(Request $request)
    {
//        $params = $request->query->all();
//        $limit = $request->query->get('limit');
//        $offset = $request->query->get('offset');
//        $photos = $this->get('app.gallery.photo')->getPhotosByDTO($params, $limit, $offset);
//
//        $response = new Response($photos['responseData']);
//        $response->headers->set('X-total-count', $photos['count']);

        return $this->get('app.repository.gallery.photo')->findAll();
//        return View::create($this->get('app.repository.gallery.photo')->findAll(), 200, ['X-Total-Count' => 200]);
    }

    /**
     * @Rest\Post("/photos")
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "photoRequestDTO",
     *     converter="fos_rest.request_body",
     *     options={
     *         "deserializationContext"={"groups"="api_photo_request"}
     *     }
     * )
     */
    public function createPhotoAction(PhotoDTO $photoRequestDTO)
    {
        $this
            ->get('app.repository.gallery.photo')
            ->addPhoto($photoRequestDTO)
        ;
    }

    /**
     * @Rest\Get("/photos/{id}")
     * @Rest\View(serializerGroups="api_photo_get", statusCode=200)
     */
    public function getPhotoAction($id)
    {
        return $this
            ->get('app.gallery.photo')
            ->getPhoto($id)
            ;
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
            ->updatePhoto($id, $photoRequestDTO)
        ;
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