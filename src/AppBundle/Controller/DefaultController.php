<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Post("/processmail", name="processmail")
     */
    public function indexAction(Request $request)
    {
        return new View("Mail traité", Response::HTTP_OK);
    }
}
