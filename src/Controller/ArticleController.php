<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Article;

/**
 * Class ArticleController
 * @package App\Controller\Admin
 *
 * @Route("/article")
 */

class ArticleController extends AbstractController
{
    /**
     * id de l'utilisateur
     * @Route("/{id}")
     */
    public function index(User $user,Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $article->setAuteur($this->getUser());
                $article->setDatePublication(new \DateTime());
                $image=$article->getImage();
                if(!is_null($image)){
                    $newimage=uniqid().''.$image->guessExtension();
                    $article->setImage($newimage);
                    $image->move($this->getParameter('upload_dir'),$newimage);
                }
                $manager->persist($article);
                $manager->flush();
            }
        }

        return $this->render('article/index.html.twig',
            ['user'=>$user,'form'=>$form->createView()]);
    }

    /**
     * id de l'article
     * @Route("/delete/{id}")
     */
    public function delete(Article $article){
        $manager = $this->getDoctrine()->getManager();

        if(!is_null($article->getImage())){
            unlink($this->getParameter('upload_dir').$article->getImage());
        }

        $user=$article->getAuteur();
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute('app_article_index',['id'=>$user->getId()]);
    }

}
