<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Movie;
use App\Form\MovieType;

/** 
 * Movie Controller
 * @Route("/api", name="api_")
*/
class MovieController extends FOSRestController
{
    /**
     * Create Movie
     * @Rest\Post("/movie")
     * 
     * @return Response
     */
    public function postMovieAction(Request $request)
    {
        $movie = new Movie();

        $form = $this->createForm(MovieType)
    }
}