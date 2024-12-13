<?php

namespace App\Controller;
use App\Entity\Articles;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ArticlesRepository;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
class ArticlesController extends AbstractController
{ 
    // Ajouter des articles

    #[Route(path: '/api/add_articles', name: 'admin_add_articles', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function Add_Articles(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $articles = new Articles();
        $articles-> setTitle($data['title']);
        $articles-> setContent($data['content']);
      
        $em->persist($articles);

        $em->flush();


        return new JsonResponse(["message" => "New article added ! "], 200);
        

    }

    //Modifier un article
    #[Route(path: '/api/edit_articles/{id}', name: 'admin_edit_articles', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function Edit_Articles(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        ArticlesRepository $articlesRepository
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $article = $articlesRepository->find($id);

        if (isset($data['title'])) {
            $article->setTitle($data['title']);
        }
        if (isset($data['content'])) {
            $article->setContent($data['content']);
        }

        $em->flush();

        return new JsonResponse(["message" => "The article has been modified ! "], 200);
        
    }

    // Suprimer un article
    #[Route(path: '/api/delete_articles/{id}', name: 'admin_delete_articles', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function Delete_Articles(
        int $id,
        Request $request,
        EntityManagerInterface $em,
        ArticlesRepository $articlesRepository
    ): JsonResponse
    {
       $articles = $articlesRepository->find($id);

        // Supprimer l'entrée
        $em->remove($articles);
        $em->flush();

        return new JsonResponse(["message" => "The article has been deleted! "], 200);
        
    }

}
