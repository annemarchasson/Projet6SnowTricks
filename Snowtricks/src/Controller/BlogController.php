<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Article;
use App\Entity\Image;
use App\Entity\Video;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\FigureType;

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
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $em){

        if(!$article){
            $article = new Article();

        }

        $form = $this->createForm(FigureType::class, $article);

        // analyse la requete http
        $form->handleRequest($request);

        // si article soumis et valide
        if ($form->isSubmitted() && $form->isValid()){

            // et qu'il n'existe pas déjà, n'a déjà pas d'ID
            if(!$article->getId()) {

                // alors création d'une date
                $article->setCreatedAt(new \DateTime());

                //récupération image
                $image = $form->get('image')->getData();


                // On boucle sur les images
                foreach($image as $image){
                    // On génère un nouveau nom de fichier
                    $fichier = md5(uniqid()).'.'.$image->guessExtension();

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );

                    // On crée l'image dans la base de données
                    $img = new Image();
                    $img->setName($fichier);
                    $article->addImage($img);

                }


                //récupération video
                $video = $form->get('video')->getData();

                // On boucle sur les videos
                foreach($video as $video){

                    // On crée la video dans la base de données
                    $vid = new Video();
                    $article->addVideo($vid);
                }

                //foreach($article->getVideo() as $video)
                //{
                //   $video->setArticles($article);
                //   $em->persist($video);
                //}


            }

            var_dump($video);

            $em->persist($article);
            // on envoie les données sur la database
            $em->flush();

            return $this->redirectToRoute('blog_show', ['id' =>$article->getId()]);

        }

        //pour afficher le formulaire
        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !==null

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
