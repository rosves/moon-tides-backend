<?php

namespace App\Controller;

use App\Entity\Affirmations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffirmationsController extends AbstractController
{
    // Route pour ajouter une nouvelle affirmation (citation)
    #[Route('/api/affirmations', name: 'add_affirmation', methods: ['POST'])]
    public function addAffirmation(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Récupération des données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si le champ 'content' existe et n'est pas vide
        if (!isset($data['content']) || empty($data['content'])) {
            return new JsonResponse(['message' => 'Content is required'], 400); // Retourner une erreur 400 si le contenu est vide
        }

        // Créer une nouvelle instance de l'entité Affirmations
        $affirmation = new Affirmations();
        $affirmation->setContent($data['content']); // Définir le contenu de l'affirmation

        // Persister l'affirmation dans la base de données
        $em->persist($affirmation);
        $em->flush(); // Appliquer les changements dans la base de données

        // Retourner une réponse JSON avec un message de succès et un code 201 (Création réussie)
        return new JsonResponse(['message' => 'Affirmation added successfully'], 201);
    }

    // Route pour mettre en avant une affirmation (la marquer comme "highlighted")
    #[Route('/api/affirmation/highlight', name: 'highlight_affirmation', methods: ['POST'])]
    public function highlightAffirmation(Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Récupérer les données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si l'ID de l'affirmation est fourni
        if (empty($data['id'])) {
            return new JsonResponse(['message' => 'Affirmation ID is required'], 400); // Retourner une erreur 400 si l'ID est manquant
        }

        // Chercher l'affirmation dans la base de données via son ID
        $repository = $em->getRepository(Affirmations::class);
        $affirmation = $repository->find($data['id']);

        // Si l'affirmation n'est pas trouvée, retourner une erreur 404
        if (!$affirmation) {
            return new JsonResponse(['message' => 'Affirmation not found'], 404);
        }

        // Marquer l'affirmation comme mise en avant
        $affirmation->setHighlighted(true);
        $affirmation->setHighlightedSince(new \DateTimeImmutable()); // Enregistrer la date à laquelle elle a été mise en avant

        // Réinitialiser les autres affirmations pour ne laisser qu'une seule mise en avant
        $allAffirmations = $repository->findAll();
        foreach ($allAffirmations as $entry) {
            // Si l'affirmation n'est pas celle actuellement mise en avant, la réinitialiser
            if ($entry !== $affirmation) {
                $entry->setHighlighted(false);
                $entry->setHighlightedSince(null);
            }
            $em->persist($entry); // Persister les modifications des autres affirmations
        }

        // Appliquer toutes les modifications dans la base de données
        $em->flush();

        // Retourner une réponse JSON avec un message de succès
        return new JsonResponse(['message' => 'Affirmation highlighted successfully'], 200);
    }

    // Route pour récupérer l'affirmation actuellement mise en avant
    #[Route('/api/affirmation/current', name: 'current_affirmation', methods: ['GET'])]
    public function getCurrentHighlightedAffirmation(EntityManagerInterface $em): JsonResponse
    {
        // Chercher l'affirmation actuellement mise en avant dans la base de données
        $repository = $em->getRepository(Affirmations::class);
        $highlightedAffirmation = $repository->findOneBy(['is_highlighted' => true]);

        // Si aucune affirmation mise en avant n'est trouvée, retourner une erreur 404
        if (!$highlightedAffirmation) {
            return new JsonResponse(['message' => 'No highlighted affirmation found'], 404);
        }

        // Retourner l'affirmation mise en avant sous forme de réponse JSON
        return new JsonResponse([
            'id' => $highlightedAffirmation->getId(),
            'content' => $highlightedAffirmation->getContent(),
            'highlighted_since' => $highlightedAffirmation->getHighlightedSince()->format('Y-m-d H:i:s'),
        ], 200);
    }
}
