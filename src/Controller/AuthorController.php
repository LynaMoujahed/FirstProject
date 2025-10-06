<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'list_authors')]
    public function listAuthors(ManagerRegistry $mr): Response
    {
        $authors = $mr->getRepository(Author::class)->findAll();

        return $this->render('author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    // #[Route('/author/{id}', name: 'author_details')]
    // public function authorDetails(int $id, ManagerRegistry $mr): Response
    // {
    //     $author = $mr->getRepository(Author::class)->find($id);

    //     if (!$author) {
    //         throw $this->createNotFoundException('Auteur non trouvé');
    //     }

    //     return $this->render('author/show.html.twig', [
    //         'author' => $author
    //     ]);
    // }

    #[Route('/add-author', name: 'add_author')]
    public function addAuthor(ManagerRegistry $mr): Response
    {
        $author = new Author();
        $author->setUsername("Lyna Moujahed")
            ->setEmail("lyna@gmail.com")
            ->setNbBooks(12)
            ->setPicture("images/lyna.jpg");

        $entityManager = $mr->getManager();
        $entityManager->persist($author);
        $entityManager->flush();

        return new Response("Author added with ID: " . $author->getId());
    }

    #[Route('/update-author/{id}', name: 'update_author')]
    public function updateAuthor(int $id, ManagerRegistry $mr): Response
    {
        $entityManager = $mr->getManager();
        $author = $entityManager->getRepository(Author::class)->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $author->setUsername("Updated Name")
               ->setNbBooks(99)
               ->setEmail("updated@example.com");

        $entityManager->flush();

        return new Response("Author updated successfully!");
    }

    #[Route('/delete-author/{id}', name: 'delete_author')]
    public function deleteAuthor(int $id, ManagerRegistry $mr): Response
    {
        $entityManager = $mr->getManager();
        $author = $entityManager->getRepository(Author::class)->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Author not found');
        }

        $entityManager->remove($author);
        $entityManager->flush();

        return new Response("Author deleted successfully!");
    }
}
