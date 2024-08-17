<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

   /**
    * @Route("/", name="create", methods={"POST"})
    */
   public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
   {
       $requestData = $request->getContent();

       $user = $serializer->deserialize($requestData, User::class, 'json');

       if (!$user->getEmail() || !$user->getPassword()) {
           return new JsonResponse(['error' => 'Missing required fields'], 400);
       }
       
       $entityManager->persist($user);
       $entityManager->flush();

       $data = $serializer->serialize($user, 'json');

       return new JsonResponse(['message' => 'Product created!', 'product' => json_decode($data)], 201);
   }

}
