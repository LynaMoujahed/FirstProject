<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * Exercice 1 - Afficher un auteur par nom
     */
    #[Route('/author/{name}', name: 'show_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name
        ]);
    }

    /**
     * Exercice 2 - Liste des auteurs avec données de l'entité
     */
    #[Route('/authors', name: 'list_authors')]
    public function listAuthors(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les auteurs depuis la base de données
        $authors = $entityManager->getRepository(Author::class)->findAll();

        // Si pas d'auteurs en base, utiliser des données de démonstration
        if (empty($authors)) {
            $authors = $this->getDemoAuthors($entityManager);
        }

        return $this->render('author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * Exercice 2 - Détails d'un auteur avec entité
     */
    #[Route('/author/details/{id}', name: 'author_details')]
    public function authorDetails($id, EntityManagerInterface $entityManager): Response
    {
        $author = $entityManager->getRepository(Author::class)->find($id);

        // Si l'auteur n'est pas trouvé
        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * Méthode pour créer des données de démonstration
     */
    private function getDemoAuthors(EntityManagerInterface $entityManager): array
    {
        $authorsData = [
            [
                'username' => 'Victor Hugo', 
                'email' => 'victor.hugo@gmail.com', 
                'nb_books' => 100,
                'picture' => 'images/Victor-Hugo.jpg'
            ],
            [
                'username' => 'William Shakespeare', 
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200,
                'picture' => 'images/william-shakespeare.jpg'
            ],
            [
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com', 
                'nb_books' => 300,
                'picture' => 'images/Taha_Hussein.jpg'
            ],
        ];

        $authors = [];
        foreach ($authorsData as $data) {
            $author = new Author();
            $author->setUsername($data['username']);
            $author->setEmail($data['email']);
            $author->setNbBooks($data['nb_books']);
            $author->setPicture($data['picture']);
            
            $entityManager->persist($author);
            $authors[] = $author;
        }
        
        $entityManager->flush();

        return $authors;
    }
}