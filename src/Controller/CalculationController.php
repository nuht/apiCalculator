<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Calculation;
use App\Entity\AccessToken;
use App\Entity\User;
use App\Form\CalculationType;

/** 
 * Calculation Controller
 * @Route("/api", name="api_")
*/
class CalculationController extends FOSRestController
{

    /**
     * Lists all Calculations
     * @Rest\Get("/calculations")
     * 
     * @return Response
     */
    public function getCalculations(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Calculation::class);
        $calculations = $repository->findall();

        return $this->handleView($this->view($calculations));
    }

    /**
     * Create Calculate and his Result from the addition
     * @Rest\Post("/addition")
     * 
     * @return Response
     */
    public function addition(Request $request)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $headers = getallheaders();
        $authorizationHeader = $headers['Authorization'];
        $token = substr($authorizationHeader, 7);
        $accessTokenRepository = $this->getDoctrine()->getRepository(AccessToken::class);
        $accessToken = $accessTokenRepository->findOneBy(['token' => $token]);
        $userId = $accessToken->getUser()->getId();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->find($userId);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            
            $calculation->setResult($calculation->getParameterOne() + $calculation->getParameterTwo());
            $calculation->setCalculType('addition');
            $calculation->setUser($user);

            $em->persist($calculation);
            $em->flush();

            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }

    /**
     * Create Calculate and his Result from the subtract
     * @Rest\Post("/subtraction")
     * 
     * @return Response
     */
    public function subtraction(Request $request)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            
            $calculation->setResult($calculation->getParameterOne() - $calculation->getParameterTwo());
            $calculation->setCalculType('subtraction');

            $em->persist($calculation);
            $em->flush();

            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }

    /**
     * Create Calculate and his Result from the multiply
     * @Rest\Post("/multiplication")
     * 
     * @return Response
     */
    public function multiplication(Request $request)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            
            $calculation->setResult($calculation->getParameterOne() * $calculation->getParameterTwo());
            $calculation->setCalculType('multiplication');

            $em->persist($calculation);
            $em->flush();

            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
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
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            
            $calculation->setResult($calculation->getParameterOne() / $calculation->getParameterTwo());
            $calculation->setCalculType('division');

            $em->persist($calculation);
            $em->flush();

            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }
}
