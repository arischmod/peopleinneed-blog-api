<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/blogs')]
class BlogController extends AbstractController
{
    /**
    * @Route("/", name="index", methods={"GET"})
    */
    public function index(BlogRepository $blogRepository, SerializerInterface $serializer): Response
    {
        $blogs = $blogRepository->findAll();
        $data = $serializer->serialize($blogs, 'json');
 
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
 
 
    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Blog $blog, SerializerInterface $serializer): Response
    {
        $data = $serializer->serialize($blog, 'json');
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
 
 
    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $requestData = $request->getContent();
 
        $blog = $serializer->deserialize($requestData, Blog::class, 'json');
 
        if (!$blog->getTitle() || !$blog->getContent() || !$blog->getAuthor()) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }
 
        $entityManager->persist($blog);
        $entityManager->flush();
 
        $data = $serializer->serialize($blog, 'json');
 
        return new JsonResponse(['message' => 'Blog created!', 'blog' => json_decode($data)], 201);
    }
 
 
    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     */
    public function update(Blog $blog, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $requestData = $request->getContent();
        $updatedBlog = $serializer->deserialize($requestData, Blog::class, 'json');
 
        $blog->setTitle($updatedBlog->getTitle());
        $blog->setContent($updatedBlog->getContent());
        
        $entityManager->flush();
 
        return new Response('Blog updated!', 200);
    }
 
 
    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($blog);
        $entityManager->flush();
 
        return new Response('Blog deleted!', 200);
    }
 
 
    /**
     * @Route("/search/{id}", name="search_by_id", methods={"GET"})
     */
    public function findById(BlogRepository $blogRepository, int $id, SerializerInterface $serializer): Response
    {
        $blog = $blogRepository->find($id);
 
        if (!$blog) {
            return new JsonResponse(['error' => 'Blog not found'], 404);
        }
 
        $data = $serializer->serialize($blog, 'json');
 
        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
}
