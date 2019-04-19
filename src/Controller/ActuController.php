<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/actu")
 */
class ActuController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        //$articles = [];
//        $amis = $user->getAmis();
//        foreach ($amis as $ami) {
//            dump($ami->getSuivi());
//            $articles[]= $ami->getSuivi()->getArticles();
//            foreach($articles as $article) {
//                //dump();
//            }
//        }

        $articles = $repository->getByUserFriends($this->getUser());
        /*
        foreach($articles as $article){
            dump($article->);
        }*/
        //$articles = $repository->findAll(["auteur"=>$user->getAmis()->]);
        return $this->render('actu/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
