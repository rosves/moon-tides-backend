<?php

namespace App\Controller;

use App\Entity\Journal;
use App\Entity\NoteEntries;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NoteEntriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JournalController extends AbstractController
{
    #[Route('/api/getentries', name: 'get_entries', methods: ['GET'])]
    public function GetEntries(NoteEntriesRepository $noteEntriesRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        // Récupérer l'utilisateur actuellement connecté
        $UserConnected = $this->getUser();
        if (!$UserConnected) {
            // Retourner une réponse JSON indiquant que l'utilisateur n'est pas authentifié
            return new JsonResponse(['message' => 'User not authenticated'], 401);
        }
        
        // Récupérer le journal associé à l'utilisateur connecté
        $journal = $UserConnected->getJournal();
        if (!$journal) {
            // Retourner une réponse JSON si aucun journal n'est trouvé
            return new JsonResponse(['message' => 'No journal entries found'], 404);
        }

        // Récupérer les entrées du journal en fonction de l'ID du journal
        $notedata = $noteEntriesRepository->findBy(['CreateNote' => $journal->getId()]);
        
        // Sérialiser les données récupérées en JSON avec des groupes de sérialisation spécifiques
        $serializedata = $serializerInterface->serialize($notedata, "json", ["groups" => ["user:noteentries"]]);
        
        // Retourner une réponse JSON contenant les données sérialisées
        return new JsonResponse(['notedata' => json_decode($serializedata)], 200);
    }

    #[Route('/api/createEntries', name: 'create_entries', methods: ['POST'])]
    public function CreateEntries(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        // Récupérer les données envoyées depuis le front-end en JSON
        $data = json_decode($request->getContent(), true);
        
        // Récupérer l'utilisateur actuellement connecté
        $UserConnected = $this->getUser();
        
        // Récupérer le journal associé à cet utilisateur
        $journal = $UserConnected->getJournal();
        
        // Créer une nouvelle instance de l'entité NoteEntries
        $entries = new NoteEntries();
        
        // Définir le contenu et le titre de la note en utilisant les données reçues
        $entries->setNoteContent($data['content']);
        $entries->setNoteTitle($data['title']);
        
        // Associer la note au journal de l'utilisateur
        $entries->setCreateNote($journal);
        
        // Persister l'entité pour l'enregistrer dans la base de données
        $em->persist($entries);
        
        // Appliquer les changements dans la base de données
        $em->flush();

        // Retourner une réponse JSON confirmant que l'entrée a été ajoutée
        return new JsonResponse(["message" => "Entries added ! "], 200);
    }

    #[Route('/api/editEntries/{id}', name: 'edit_entries', methods: ['PATCH'])]
    public function UpdateEntries(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        NoteEntriesRepository $noteEntriesRepository
    ): JsonResponse {
        // Récupérer l'utilisateur actuellement connecté
        $UserConnected = $this->getUser();
        if (!$UserConnected) {
            return new JsonResponse(['message' => 'User not authenticated'], 401);
        }

        // Récupérer l'entrée à modifier par son ID
        $entry = $noteEntriesRepository->find($id);
        if (!$entry) {
            return new JsonResponse(['message' => 'Note entry not found'], 404);
        }

        // S'assurer que l'entrée appartient au journal de l'utilisateur connecté
        $journal = $UserConnected->getJournal();
        if ($entry->getCreateNote() !== $journal) {
            return new JsonResponse(['message' => 'You do not have permission to edit this entry'], 403);
        }

        // Récupérer les données envoyées dans la requête (titre et contenu de la note)
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données existent et les appliquer
        if (isset($data['title'])) {
            $entry->setNoteTitle($data['title']);
        }
        if (isset($data['content'])) {
            $entry->setNoteContent($data['content']);
        }

        // Persister les modifications dans la base de données
        $em->flush();

        // Retourner une réponse JSON confirmant que l'entrée a été mise à jour
        return new JsonResponse(['message' => 'Entry updated successfully'], 200);
    }

    #[Route('/api/deleteEntries/{id}', name: 'delete_entries', methods: ['DELETE'])]
    public function DeleteEntries(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        NoteEntriesRepository $noteEntriesRepository
    ): JsonResponse {
        $UserConnected = $this->getUser();
        if (!$UserConnected) {
            return new JsonResponse(['message' => 'User not authenticated'], 401);
        }

        // Récupérer l'entrée du journal à supprimer par son ID
        $noteEntry = $noteEntriesRepository->find($id);
        
        if (!$noteEntry) {
            // Retourner un message d'erreur si l'entrée n'est pas trouvée
            return new JsonResponse(['message' => 'Note entry not found'], 404);
        }

        // Vérifier si l'utilisateur connecté est bien l'auteur de l'entrée (si nécessaire)
        if ($noteEntry->getCreateNote()->getId() !== $UserConnected->getJournal()->getId()) {
            // Retourner une erreur si l'utilisateur n'est pas l'auteur
            return new JsonResponse(['message' => 'You are not authorized to delete this entry'], 403);
        }

        // Supprimer l'entrée
        $em->remove($noteEntry);
        $em->flush();

        // Retourner une réponse de succès
        return new JsonResponse(['message' => 'Entry deleted successfully'], 200);
        }
}
