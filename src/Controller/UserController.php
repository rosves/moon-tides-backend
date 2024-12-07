<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Journal;
use App\Entity\MoonNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class UserController extends AbstractController
{ // REGISTER
    #[Route('/api/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager 
    ): JsonResponse {
        // to get the information from the front 
        // Get the data from the request
        $data = json_decode($request->getContent(), true);

        // Validation that none of the important fields are missing
        if (empty($data['email']) || empty($data['password']) || empty($data['username'])) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        // Check if user (email) already exists
        $existingUser = $em->getRepository(Users::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email already registered'], 400);
        }

        // Check if user already exists
        $existingUser = $em->getRepository(Users::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email already registered'], 400);
        }

        //  To create a new user
        $user = new Users();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        // To hash the password
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Set roles > (default: ROLE_USER)
        $user->setRoles(['ROLE_USER']);

        // Automatically create a personal journal for the user
        $journal = new Journal();
        $user -> setJournal($journal);

        $notification = new MoonNotification();
        $user-> setNotifymoon($notification);

        // Persist the user and journal
        $em->persist($user);
        $em->persist($journal);
         
        // Save to database
        $em->flush();

        $token = $jwtManager->create($user);
        

        // Return success response(201 > created)
        return new JsonResponse(['message' => 'User registered successfully','token' => $token], 201);
    }

}
