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
{ // REGISTER
    #[Route('/api/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManager $em,
        UserPasswordHasher $passwordHasher
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
        $journal->setUser($user);

        // Persist the user and journal
        $em->persist($user);
        $em->persist($journal);

        // Save to database
        $em->flush();

        // Return success response(201 > created)
        return new JsonResponse(['message' => 'User registered successfully'], 201);
    }

    #[Route('/api/login', name : 'user_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManager $em,
        UserPasswordHasher $passwordHasher
    ): JsonResponse {

         // Get the data from the request
         $data = json_decode($request->getContent(), true);

        //  Verification of the fields with right infos
         if(empty($data['email']) || empty($data['password'])){
            return new JsonResponse(['error' => 'Email and password are required'], 400);
         }

        //  Look for the user + 401 = unauthorized
         $user = $em ->getRepository(Users::class)->findOneBy(['email' => $data['email']]);
         if (!$user) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
         }

          // Verification of the password
    if (!$passwordHasher->isPasswordValid($user, $data['password'])) {
        return new JsonResponse(['error' => 'Invalid credentials'], 401);
    }
// ok = 200
    return new JsonResponse(['message' => 'Login successful', 'user_id' => $user->getId()], 200);
    }
}
