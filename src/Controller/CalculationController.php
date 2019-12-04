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
use App\Service\CurrentUserService;
use Doctrine\ORM\EntityManagerInterface;

/** 
 * Calculation Controller
 * @Route("/api", name="api_")
*/
class CalculationController extends FOSRestController
{
    /**
     * Lists all Calculations
     * @Rest\Get("/getCalculations")
     * 
     * @return Response
     */
    public function getCalculations(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        $repository     = $em->getRepository(Calculation::class);
        $user           = $currentUserService->getCurrentUser(getallheaders());
        $calculations   = $repository->findBy(['user' => $user->getId()]);

        return $this->handleView($this->view($calculations));
    }

    /**
     * Delete last user calculation
     * @Rest\Get("/deleteLastCalculation")
     * 
     * @return Response
     */
    public function deleteLastUserCalculation(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {

        $repository             = $em->getRepository(Calculation::class);
        $user                   = $currentUserService->getCurrentUser(getallheaders());
        $lastUserCalculation    = $repository->deleteLastUserCalculation($user->getId());

        if (empty($lastUserCalculation)) 
        {
            return $this->handleView($this->view(['status' => 'user doesn\'t have any result'], Response::HTTP_BAD_REQUEST));
        }

        $em->remove($lastUserCalculation[0]);
        $em->flush();

        return $this->handleView($this->view(['status' => 'last calculation deleted'], Response::HTTP_CREATED));
    }

    /**
     * Create Calculate and his Result from the addition
     * @Rest\Post("/addition")
     * 
     * @return Response
     */
    public function addition(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $user = $currentUserService->getCurrentUser(getallheaders());

        if($form->isSubmitted() && $form->isValid()) 
        {
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
    public function subtraction(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $user = $currentUserService->getCurrentUser(getallheaders());

        if($form->isSubmitted() && $form->isValid()) 
        {
            $calculation->setResult($calculation->getParameterOne() - $calculation->getParameterTwo());
            $calculation->setCalculType('subtraction');
            $calculation->setUser($user);

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
    public function multiplication(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $user = $currentUserService->getCurrentUser(getallheaders());

        if($form->isSubmitted() && $form->isValid()) 
        {
            $calculation->setResult($calculation->getParameterOne() * $calculation->getParameterTwo());
            $calculation->setCalculType('multiplication');
            $calculation->setUser($user);

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
    public function division(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        $calculation    = new Calculation();

        $form = $this->createForm(CalculationType::class, $calculation);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        $user = $currentUserService->getCurrentUser(getallheaders());

        if($form->isSubmitted() && $form->isValid()) 
        {
            $calculation->setResult($calculation->getParameterOne() / $calculation->getParameterTwo());
            $calculation->setCalculType('division');
            $calculation->setUser($user);

            $em->persist($calculation);
            $em->flush();

            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
        return $this->handleView($this->$view($form->getErrors()));
    }
}
