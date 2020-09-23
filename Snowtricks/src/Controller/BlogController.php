<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class BlogController extends AbstractController
{


    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }



    /**
     * @Route("/", name="home")
     */
    public function  home(){
        return $this->render('blog/home.html.twig');
    }



    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, EntityManagerInterface $em){
        $article = new Article();

        $form = $this->createFormBuilder($article)
                     -> add('title')
                     -> add('description')
                     -> add('image')
                     ->getForm();

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }



    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id){
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}
