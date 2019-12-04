<?php

namespace App\Service;

use App\Entity\AccessToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CurrentUserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }

    public function getCurrentUser(Array $headers) 
    {
        $authorizationHeader = $headers['Authorization'];
        $token = substr($authorizationHeader, 7);
        $accessTokenRepository = $this->em->getRepository(AccessToken::class);
        $accessToken = $accessTokenRepository->findOneBy(['token' => $token]);
        $userId = $accessToken->getUser()->getId();
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->find($userId);

        return $user;
    }

}