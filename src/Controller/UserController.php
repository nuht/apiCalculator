<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\UserBundle\Model\UserManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Service\CurrentUserService;


/** 
 * User Controller
 * 
 **/
class UserController extends FOSRestController
{
    private $fosUserManager;
    
    private $currentUserService;

    /**
     * Constructor
     *
     * @param UserManagerInterface $fosUserManager
     * @param CurrentUserService $currentUserService
     */
    public function __construct(UserManagerInterface $fosUserManager, CurrentUserService $currentUserService)
    {
        $this->fosUserManager = $fosUserManager;
        $this->currentUserService = $currentUserService;
    }

    /**
     * Create User
     * @FOSRest\Post("/register")
     * 
     * @param Request $request
     * @param UserManagerInterface $fosUserManager
     * @return Response
     **/
    public function RegisterAction(Request $request, UserManagerInterface $fosUserManager)
    {
        // Create new User
        $user = new User();

        // Get request data
        $data = json_decode($request->getContent(), true);

        // Throw bad request if any of the parameter are empty
        if ($data === null || $data['username'] === '' || $data['email'] === '' || $data['password'] === '') 
        {
            throw new BadRequestHttpException();
        }

        // Check if email or username already exists
        $emailExist = $fosUserManager->findUserByEmail($data['email']);
        $userExist  = $fosUserManager->findUserByUsername($data['username']);

        if ($userExist)
        {
            return $this->handleView($this->view(['status' => 'username already taken'], Response::HTTP_BAD_REQUEST));
        }

        if ($emailExist)
        {
            return $this->handleView($this->view(['status' => 'email already taken'], Response::HTTP_BAD_REQUEST));
        }

        //  Check if email is valid
        if (!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i",$data['email']))
        {
            return $this->handleView($this->view(['status' => 'invalid email'], Response::HTTP_BAD_REQUEST));
        }

        // Check for password length
        if (strlen($data['password']) < 8)
        {
            return $this->handleView($this->view(['status' => 'password must be at least 8 characters long'], Response::HTTP_BAD_REQUEST));
        }

        // Set user parameters
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setEmailCanonical($data['email']);
        $user->setEnabled(1);
        $user->setPlainPassword($data['password']);
        $user->setRoles(['ROLE_USER']);

        // Save
        $fosUserManager->updateUser($user);

        // Return status code
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * Create User
     * @FOSRest\Post("/updateUser")
     * 
     * @param Request $request
     * @param UserManagerInterface $fosUserManager
     * @param CurrentUserService $currentUserService
     * @return Response
     **/
    public function UpdateUserAction(Request $request, UserManagerInterface $fosUserManager, CurrentUserService $currentUserService)
    {
        // Get current user from access token in header with currentUserService
        $user = $currentUserService->getCurrentUser(getallheaders());

        // Get request data
        $data = json_decode($request->getContent(), true);

        // Throw bad request if any of the parameter are empty
        if ($data === null || $data['username'] === '' || $data['email'] === '' || $data['password'] === '') 
        {
            throw new BadRequestHttpException();
        }

        // Check if email or username already exists
        $emailExist = $fosUserManager->findUserByEmail($data['email']);
        $userExist  = $fosUserManager->findUserByUsername($data['username']);

        if ($userExist)
        {
            return $this->handleView($this->view(['status' => 'username already taken'], Response::HTTP_BAD_REQUEST));
        }

        if ($emailExist)
        {
            return $this->handleView($this->view(['status' => 'email already taken'], Response::HTTP_BAD_REQUEST));
        }

        //  Check if email is valid
        if (!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i",$data['email']))
        {
            return $this->handleView($this->view(['status' => 'invalid email'], Response::HTTP_BAD_REQUEST));
        }

        // Check for password length
        if (strlen($data['password']) < 8)
        {
            return $this->handleView($this->view(['status' => 'password must be at least 8 characters long'], Response::HTTP_BAD_REQUEST));
        }

        // Set user parameters
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setEmailCanonical($data['email']);
        $user->setEnabled(1);
        $user->setPlainPassword($data['password']);
        $user->setRoles(['ROLE_USER']);

        // Save
        $fosUserManager->updateUser($user);

        // Return status code
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
}