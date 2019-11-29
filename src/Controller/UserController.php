<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\UserBundle\Model\UserManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


/** 
 * User Controller
 * 
 **/
class UserController extends FOSRestController
{
    private $fosUserManager;

    public function __construct(UserManagerInterface $fosUserManager)
    {
        $this->fosUserManager = $fosUserManager;
    }

    /**
     * Create User
     * @FOSRest\Post("/register")
     * 
     * @return Response
     **/
    public function RegisterAction(Request $request, UserManagerInterface $fosUserManager)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $data = json_decode($request->getContent(), true);

        if ($data === null || $data['username'] === '' || $data['email'] === '' || $data['password'] === '') 
        {
            throw new BadRequestHttpException();
        }

        $emailExist = $fosUserManager->findUserByEmail($data['email']);
        $userExist = $fosUserManager->findUserByUsername($data['username']);

        if ($userExist)
        {
            return $this->handleView($this->view(['status' => 'username already taken'], Response::HTTP_BAD_REQUEST));
        }

        if ($emailExist)
        {
            return $this->handleView($this->view(['status' => 'email already taken'], Response::HTTP_BAD_REQUEST));
        }

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setEmailCanonical($data['email']);
        // $user->setLocked(0);
        $user->setEnabled(1);
        $user->setPlainPassword($data['password']);
        $user->setRoles(['ROLE_USER']);

        $fosUserManager->updateUser($user);

        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));

        // $form->submit($data);

        // if($form->isSubmitted() && $form->isValid())
        // {
        //     dump('hello');
        //     $emailExist = $fosUserManager->findUserByEmail($data['email']);

        //     if ($emailExist)
        //     {
        //         $this->handleView($this->view(['status' => 'user already exists'], Response::HTTP_BAD_REQUEST));
        //     }

        //     $user->setUsername($data['username']);
        //     $user->setEmail($data['email']);
        //     $user->setEmailCanonical($data['email']);
        //     $user->setLocked(0);
        //     $user->setEnabled(1);
        //     $user->setPlainPassword($data['password']);

        //     $fosUserManager->updateUser($user);

        //     return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        // }
    }
}