<?php

namespace App\Service;

use App\Entity\AccessToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CurrentUserService
{
    private $em;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }

    /**
     * Get Current User from access token given in header
     *
     * @param Array $headers
     * @return User $user
     */
    public function getCurrentUser(Array $headers) 
    {
        // Get Authorization headers from all headers
        $authorizationHeader = $headers['Authorization'];

        // Get token
        $token = substr($authorizationHeader, 7);

        // Get access token repository
        $accessTokenRepository = $this->em->getRepository(AccessToken::class);

        // Get access token by token from authorization header
        $accessToken = $accessTokenRepository->findOneBy(['token' => $token]);

        // Get user id from access token user id parameter
        $userId = $accessToken->getUser()->getId();

        // Get user repository
        $userRepository = $this->em->getRepository(User::class);

        // Get user
        $user = $userRepository->find($userId);

        // Return user
        return $user;
    }

}