<?php

namespace App\Controller;

use App\Entity\Ritual;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\RitualRepository;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class RitualsController extends AbstractController
{

    #[Route(path: '/api/add_ritual', name: 'admin_add_ritual', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function Add_Rituals(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $Rituals = new Ritual();
        $Rituals->setRitualName($data['name']);
        $Rituals->setLink($data['link']);

        $em->persist($Rituals);

        $em->flush();


        return new JsonResponse(["message" => "New ritual added ! "], 200);
    }
    // modifier un rituel 
    #[Route(path: '/api/edit_ritual/{id}', name: 'admin_edit_ritual', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function Edit_Rituals(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        RitualRepository $ritualRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $ritual = $ritualRepository->find($id);
        if (isset($data['name'])) {
            $ritual->setRitualName($data['name']);
        }
        if (isset($data['link'])) {
            $ritual->setLink($data['link']);
        }

        $em->flush();


        return new JsonResponse(["message" => " Ritual edited ! "], 200);
    }
    
      // Suprimer un article
      #[Route(path: '/api/delete_ritual/{id}', name: 'admin_delete_ritual', methods: ['DELETE'])]
      #[IsGranted('ROLE_ADMIN')]
      public function Delete_Rituals(
          int $id,
          Request $request,
          EntityManagerInterface $em,
          RitualRepository $ritualRepository
      ): JsonResponse
      {
         $rituals = $ritualRepository->find($id);
  
          // Supprimer l'entrée
          $em->remove($rituals);
          $em->flush();
  
          return new JsonResponse(["message" => "The ritual has been deleted! "], 200);
          
      }
}
