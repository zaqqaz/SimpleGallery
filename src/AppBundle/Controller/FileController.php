<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller
{
    /**
     * @Rest\POST("/{type}/upload")
     * @Rest\View(serializerGroups={"api_file_upload"}, statusCode=201)
     */
    public function uploadAction(Request $request, $type)
    {
        foreach($request->files as $file) {
            return $this->get('app.manager.file')->upload($file, $type);
        }
    }

}