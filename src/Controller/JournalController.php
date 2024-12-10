<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JournalController extends AbstractController
{
    #[Route('/api/getentries', name: 'get_entries', methods: ['GET'])]
    public function GetEntries(): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $UserConnected = $this->getUser();
        if (!$UserConnected) {
            return new JsonResponse(['message' => 'User not authenticated'], 401);
        }

        // Récupérer le journal de l'utilisateur
        $journal = $UserConnected->getJournal();
        if (!$journal) {
            return new JsonResponse(['message' => 'No journal entries found'], 404);
        }

        // Si le journal est un objet complexe, convertir en tableau
        $journalData = []; // Transformez $journal en tableau selon votre structure
        foreach ($journal as $entry) {
            $journalData[] = [
                'id' => $entry->getId(),
                'content' => $entry->getContent(),
                'date' => $entry->getDate(),
            ];
        }

        return new JsonResponse([
            'message' => 'Journal received',
            'journal' => $journalData,
        ], 200);
    }
}
