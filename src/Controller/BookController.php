<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book/add', name: 'app_book_add')]
    public function add(Request $rq, ManagerRegistry $doctrine): Response
    {
        $book=new Book();
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($rq);
            if ($form->isSubmitted()){
              //ajout dans la base 
            $aziz=$doctrine->getManager();
            $aziz->persist($book);
            $aziz->flush();
            }
        return $this->render('book/index.html.twig', [
            'myForm' => $form->createView(),
        ]);
    }

    #[Route('/book/list', name: 'app_book_list')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repo=$doctrine->getRepository(Book::class);
        $books=$repo->findAll();
        return $this->render('book/list.html.twig', [
            'list'=>$books
        ]);

    }
}
