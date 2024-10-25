<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', 
        [
            //clé : nom de la variable => valeur : valeur de la variable 
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/show/{name}', name: 'app_author_show')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', 
        [
            //clé : nom de la variable => valeur : valeur de la variable 
            'variableName' => $name, 'var2'=>'une deuxième variable'
        ]);
    }
    #[Route('/list', name: 'app_author_list')]
    public function listAuthors (AuthorRepository $repo): Response
    {
       // $authors = $repo->findAll();
       $authors = $repo->getAuthorByUserName('aziz');
       // $authors = [];
       /* $authors = array(
            array('id' => 1, 'picture' => 'images/image1.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => 'images/image2.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => 'images/image3.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );  */
        return $this->render('author/list.html.twig', 
        ['listAuthors' =>  $authors ]);}

        #[Route('/author/{usname}', name: 'app_author_list_username')]
    public function listAuthorsByUsername ($usname,AuthorRepository $repo): Response
    {
       // $authors = $repo->findAll();
       $authors = $repo->getAuthorByUserNameDQL($usname);
       // $authors = [];
       /* $authors = array(
            array('id' => 1, 'picture' => 'images/image1.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => 'images/image2.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => 'images/image3.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );  */
        return $this->render('author/list.html.twig', 
        ['listAuthors' =>  $authors ]);}



        #[Route('/details/{id}', name: 'app_author_details')]
        public function authorDetails (Request $request,AuthorRepository $repo): Response
        {
            $id=$request->get('id');
           $a = $repo ->find($id);
            /*$authors = array(
                array('id' => 1, 'picture' => 'images/image1.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
                array('id' => 2, 'picture' => 'images/image2.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
                array('id' => 3, 'picture' => 'images/image3.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
                );
                foreach ($authors as $a){
                    if ($id == $a['id']){
                        return $this->render("author/showAuthor.html.twig", ["author"=>$a]);
                    }
                }*/ 
                return $this->render("author/showAuthor.html.twig", ["author"=>$a]);
           
        }
         
        #[Route('/add', name: 'app_author_add')]
        public function add (ManagerRegistry $doctrine): Response
        {
            $author = new Author();
            $author->setUserName("author3");
            $author->setEmail('author3@gmail.com');
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            return new Response("Ajout effectué avec succès");
        }  
        #[Route('/addAuthor', name: 'app_author_add_form')]
        public function addAuthor (ManagerRegistry $doctrine, Request $request): Response
        {
            $author = new Author();
            $form=$this->createForm(AuthorType::class, $author);
            $form->add('ajouter', SubmitType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted()){
              //ajout dans la base 
            $em=$doctrine->getManager();
            $em->persist($author);
            $em->flush();
            }
            return $this->render("author/add.html.twig",
            ['f'=>$form->createView()] );
           // return $this->renderForm("author/add.html.twig",['f'=>$form] );
           
        }  

        #[Route('/updateAuthor/{id}', name: 'app_author_update_form')]
        public function updateAuthor ($id,ManagerRegistry $doctrine, 
        Request $request): Response
        {
            $author = $doctrine->getRepository(Author::class)->find($id);
            $form=$this->createForm(AuthorType::class, $author);
            $form->add('modifier', SubmitType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted()){
              //ajout dans la base 
            $em=$doctrine->getManager();
            $em->flush();
            }
            return $this->render("author/add.html.twig",
            ['f'=>$form->createView()] );
           // return $this->renderForm("author/add.html.twig",['f'=>$form] );
           
        }
           #[Route('/deleteAuthor/{id}', name: 'app_author_delete')]
           public function deleteAuthor ($id,ManagerRegistry $doctrine): Response
           {
            $author = $doctrine->getRepository(Author::class)->find($id);

            if ($author){
                $em=$doctrine->getManager();
                $em->remove($author);
                 $em->flush();
                 return new Response("suppression effectuée");
            }
           }
        }  

