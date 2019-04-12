<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(User $user)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        //$articles = $repository->findAll(['autor'=>$user],['datePublication'=>'DESC']);
        dump($user->getArticles());
        return $this->render('article/index.html.twig', ['user'=>$user]);
    }

    /**
     * @Route("/edit/{id}",defaults={"id":null})
     */
    public function editArticle(){

    }
}
