<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Journal;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/api/register', name: 'user_register', methods:['POST'])]
    public function register(
        Request $request,
        EntityManager $em,
        UserPasswordHasher $passwordHasher
    ): JsonResponse
    {
        // to get the information from the front 
        $data = json_decode($request->getContent(), true);
        $user = new Users();
        $journal = new Journal();
        $user->setEmail($data['email']);
    }
}
