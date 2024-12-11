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
{ 
    // Route pour l'inscription de l'utilisateur
    #[Route('/api/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager 
    ): JsonResponse {
        // Récupération des données envoyées depuis le front-end
        $data = json_decode($request->getContent(), true);

        // Vérification que les champs importants (email, mot de passe, nom d'utilisateur) ne sont pas manquants
        if (empty($data['email']) || empty($data['password']) || empty($data['username'])) {
            return new JsonResponse(['error' => 'Champs requis manquants'], 400);
        }

        // Vérification si l'email est déjà enregistré dans la base de données
        $existingUser = $em->getRepository(Users::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email déjà enregistré'], 400);
        }

        // Création d'un nouvel utilisateur
        $user = new Users();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        // Hachage du mot de passe avant de le stocker
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Définition des rôles de l'utilisateur (par défaut, 'ROLE_USER')
        $user->setRoles(['ROLE_USER']);

        // Création automatique d'un journal personnel pour l'utilisateur
        $journal = new Journal();
        $user->setJournal($journal);

        // Création d'une notification pour l'utilisateur
        $notification = new MoonNotification();
        $user->setNotifymoon($notification);

        // Persist des données de l'utilisateur, du journal et de la notification dans la base de données
        $em->persist($user);
        $em->persist($journal);

        // Sauvegarde dans la base de données
        $em->flush();

        // Création du token JWT pour l'utilisateur après l'inscription
        $token = $jwtManager->create($user);

        // Retour de la réponse avec un message de succès et le token JWT généré
        return new JsonResponse(['message' => 'Utilisateur inscrit avec succès', 'token' => $token], 201);
    }

}
