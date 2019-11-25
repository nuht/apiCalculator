<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Result;
use App\Entity\Calculation;
use App\Form\CalculationType;

/** 
 * Calculation Controller
 * @Route("/api", name="api_")
*/
class CalculationController extends FOSRestController
{

    /**
     * Lists all Results
     * @Rest\Get("/results")
     * 
     * @return Response
     */
    public function getResults(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Result::class);
        $results = $repository->findall();

        return $this->handleView($this->view($results));
    }

    /**
     * Create Calculate and his Result from the addition
     * @Rest\Post("/addition")
     * 
     * @return Response
     */
    public function addition(Request $request)
    {
        $result         = new Result();
        $calculation    = new Calculation($result);

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calculation);
            
            $result->setResultNumber($calculation->getParameterOne() + $calculation->getParameterTwo());

            $em->persist($result);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }

    /**
     * Create Calculate and his Result from the subtract
     * @Rest\Post("/subtract")
     * 
     * @return Response
     */
    public function subtract(Request $request)
    {
        $result         = new Result();
        $calculation    = new Calculation($result);

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calculation);
            
            $result->setResultNumber($calculation->getParameterOne() - $calculation->getParameterTwo());

            $em->persist($result);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }

    /**
     * Create Calculate and his Result from the multiply
     * @Rest\Post("/multiply")
     * 
     * @return Response
     */
    public function multiply(Request $request)
    {
        $result         = new Result();
        $calculation    = new Calculation($result);

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calculation);
            
            $result->setResultNumber($calculation->getParameterOne() * $calculation->getParameterTwo());

            $em->persist($result);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }

    /**
     * Create Calculate and his Result from the division
     * @Rest\Post("/division")
     * @return Response
     */
    public function division(Request $request)
    {
        $result         = new Result();
        $calculation    = new Calculation($result);

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calculation);
            
            $result->setResultNumber($calculation->getParameterOne() / $calculation->getParameterTwo());

            $em->persist($result);
            $em->flush();

            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }
}
