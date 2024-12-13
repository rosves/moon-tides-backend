<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Journal;
use App\Entity\MoonNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Repository\UsersRepository;
use App\Repository\ArticlesRepository;
use App\Repository\RitualRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
class AdminController extends AbstractController
{ 
    // Route pour l'inscription de l'admin

    #[Route(path: '/api/admin_register', name: 'admin_register', methods: ['POST'])]
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
            return new JsonResponse(['error' => 'Missing fields'], 400);
        }

        // Vérification si l'email est déjà enregistré dans la base de données
        $existingUser = $em->getRepository(Users::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email already used!'], 400);
        }

        // Création d'un nouvel utilisateur
        $user = new Users();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);

        // Hachage du mot de passe avant de le stocker
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Définition des rôles de l'utilisateur (par défaut, 'ROLE_ADMIN')
        $user->setRoles(['ROLE_ADMIN']);

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
        return new JsonResponse(['message' => 'Admin inscrit avec succès', 'token' => $token], 201);
    }

    // Gestion / dashboard
    #[Route(path: '/api/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboard(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager,
        UsersRepository $usersRepository,
        ArticlesRepository $articlesRepository,
        RitualRepository $ritualRepository,
        SerializerInterface $serializerInterface
    ): JsonResponse {

        $AllUsers = $usersRepository ->findAll();
        $AllArticles = $articlesRepository -> findAll();
        $AllRituals = $ritualRepository ->findAll();

        $serializedRituals = $serializerInterface->serialize($AllRituals, "json", ["groups" => ["user:rituals"]]);
        $serializedArticles = $serializerInterface->serialize($AllArticles, "json", ["groups" => ["user:articles"]]);
        $serializedUsers = $serializerInterface->serialize($AllUsers, "json", ["groups" => ["user:users"]]);

        return new JsonResponse(['rituals' => json_decode(json: $serializedRituals), "articles" => json_decode($serializedArticles), "users" => json_decode($serializedUsers)], 200);
    }

}