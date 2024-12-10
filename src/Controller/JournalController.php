<?php

namespace App\Controller;

use App\Entity\NoteEntries;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NoteEntriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class JournalController extends AbstractController
{
    #[Route('/api/getentries', name: 'get_entries', methods: ['GET'])]
    public function GetEntries(NoteEntriesRepository $noteEntriesRepository,SerializerInterface $serializerInterface): JsonResponse
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

      
       $notedata = $noteEntriesRepository->findby(['CreateNote'=> $journal->getId()]);
        $serializedata = $serializerInterface ->serialize($notedata,"json",["groups"=>["user:noteentries"]]);
       return new JsonResponse(['notedata' => json_decode($serializedata)], 200);

    }

    #[Route('/api/createEntries', name: 'create_entries', methods: ['POST'])]
    public function CreateEntries(
    Request $request,
    EntityManagerInterface $em): JsonResponse{  
        
        // To get the data from front
        $data = json_decode($request->getContent(), true);
        $UserConnected = $this->getUser();
        $journal = $UserConnected->getJournal();
        
        // To create new instance
        $entries = new NoteEntries();
        $entries -> setNoteContent($data['content']);
        $entries -> setNoteTitle($data['title']);
        $entries -> setCreateNote($journal);
        
        $em->persist($entries);

        $em->flush();

        return new JsonResponse(["message"=>"Entries added ! "],200);
    }
}
