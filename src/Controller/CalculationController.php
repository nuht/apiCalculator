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
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getCalculations(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Get calculation repository
        $repository     = $em->getRepository(Calculation::class);
        // Get current user
        $user           = $currentUserService->getCurrentUser(getallheaders());
        // Get all calculations for the current user
        $calculations   = $repository->findBy(['user' => $user->getId()]);

        // If there is no calculations throw 200
        if(empty($calculations)) {
            return $this->handleView($this->view(['status' => 'user has no calculation'], Response::HTTP_OK));
        }

        // Return found calculations
        return $this->handleView($this->view($calculations));
    }

    /**
     * Delete last user calculation
     * @Rest\Get("/deleteLastCalculation")
     * 
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function deleteLastUserCalculation(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Get calculation repository
        $repository             = $em->getRepository(Calculation::class);
        // Get current user
        $user                   = $currentUserService->getCurrentUser(getallheaders());
        // Get last user calculation with custom sql request with user id
        $lastUserCalculation    = $repository->deleteLastUserCalculation($user->getId());

        // Check if the user has no calculation
        if (empty($lastUserCalculation)) 
        {
            return $this->handleView($this->view(['status' => 'user doesn\'t have any result'], Response::HTTP_OK));
        }

        // Remove last calculation
        $em->remove($lastUserCalculation[0]);
        // Save
        $em->flush();

        // Return status code
        return $this->handleView($this->view(['status' => 'last calculation deleted'], Response::HTTP_CREATED));
    }

    /**
     * Create Calculate and his Result from the addition
     * @Rest\Post("/addition")
     * 
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function addition(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Create new Calculation
        $calculation    = new Calculation();

        // Get calculation form
        $form = $this->createForm(CalculationType::class, $calculation);
        // Get datas
        $data = json_decode($request->getContent(), true);

        // Check if data are valid int
        if (!is_int($data['parameterOne']) || !is_int($data['parameterTwo']))
        {
            // Return bad request status if there is one parameter at least incorrect
            return $this->handleView($this->view(['status' => 'one parameter or both parameters are invalid, please use only numbers'], Response::HTTP_BAD_REQUEST));
        }

        // Submit form
        $form->submit($data);

        // Get current user
        $user = $currentUserService->getCurrentUser(getallheaders());

        // Check if form is valid
        if($form->isSubmitted() && $form->isValid()) 
        {
            // Set calculation datas
            $calculation->setResult($calculation->getParameterOne() + $calculation->getParameterTwo());
            $calculation->setCalculType('addition');
            $calculation->setUser($user);

            // Persist and save calculation
            $em->persist($calculation);
            $em->flush();

            // Return status code created
            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
    }

    /**
     * Create Calculate and his Result from the subtract
     * @Rest\Post("/subtraction")
     * 
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function subtraction(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Create new Calculation
        $calculation    = new Calculation();

        // Get calculation form
        $form = $this->createForm(CalculationType::class, $calculation);
        // Get datas
        $data = json_decode($request->getContent(), true);

        // Check if data are valid int
        if (!is_int($data['parameterOne']) || !is_int($data['parameterTwo']))
        {
            // Return bad request status if there is one parameter at least incorrect
            return $this->handleView($this->view(['status' => 'one parameter or both parameters are invalid, please use only numbers'], Response::HTTP_BAD_REQUEST));
        }

        // Submit form
        $form->submit($data);

        // Get current user
        $user = $currentUserService->getCurrentUser(getallheaders());

        // Check if form is valid
        if($form->isSubmitted() && $form->isValid()) 
        {
            // Set calculation datas
            $calculation->setResult($calculation->getParameterOne() - $calculation->getParameterTwo());
            $calculation->setCalculType('subtraction');
            $calculation->setUser($user);

            // Persist and save calculation
            $em->persist($calculation);
            $em->flush();

            // Return status code created
            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
    }

    /**
     * Create Calculate and his Result from the multiply
     * @Rest\Post("/multiplication")
     * 
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function multiplication(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Create new Calculation
        $calculation    = new Calculation();

        // Get calculation form
        $form = $this->createForm(CalculationType::class, $calculation);
        // Get datas
        $data = json_decode($request->getContent(), true);

        // Check if data are valid int
        if (!is_int($data['parameterOne']) || !is_int($data['parameterTwo']))
        {
            // Return bad request status if there is one parameter at least incorrect
            return $this->handleView($this->view(['status' => 'one parameter or both parameters are invalid, please use only numbers'], Response::HTTP_BAD_REQUEST));
        }

        // Submit form
        $form->submit($data);

        // Get current user
        $user = $currentUserService->getCurrentUser(getallheaders());

        // Check if form is valid
        if($form->isSubmitted() && $form->isValid()) 
        {
            // Set calculation datas
            $calculation->setResult($calculation->getParameterOne() * $calculation->getParameterTwo());
            $calculation->setCalculType('multiplication');
            $calculation->setUser($user);

            // Persist and save calculation
            $em->persist($calculation);
            $em->flush();

            // Return status code created
            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
    }

    /**
     * Create Calculate and his Result from the division
     * @Rest\Post("/division")
     * 
     * @param Request $request
     * @param CurrentUserService $currentUserService
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function division(Request $request, CurrentUserService $currentUserService, EntityManagerInterface $em)
    {
        // Create new Calculation
        $calculation    = new Calculation();

        // Get calculation form
        $form = $this->createForm(CalculationType::class, $calculation);
        // Get datas
        $data = json_decode($request->getContent(), true);

        // Check if data are valid int
        if (!is_int($data['parameterOne']) || !is_int($data['parameterTwo']))
        {
            // Return bad request status if there is one parameter at least incorrect
            return $this->handleView($this->view(['status' => 'one parameter or both parameters are invalid, please use only numbers'], Response::HTTP_BAD_REQUEST));
        }

        // Submit form
        $form->submit($data);

        // Get current user
        $user = $currentUserService->getCurrentUser(getallheaders());

        // Check if form is valid
        if($form->isSubmitted() && $form->isValid()) 
        {
            // Set calculation datas
            $calculation->setResult($calculation->getParameterOne() / $calculation->getParameterTwo());
            $calculation->setCalculType('division');
            $calculation->setUser($user);

            // Persist and save calculation
            $em->persist($calculation);
            $em->flush();

            // Return status code created
            return $this->handleView($this->view(['result :' => $calculation->getResult()], Response::HTTP_CREATED));
        }
    }
}
