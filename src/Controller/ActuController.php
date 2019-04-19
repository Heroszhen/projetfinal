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
     * @Route("/{id}")
     */
    public function index(User $user)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        dump($user->getAmis()->co);
        //$articles = $repository->findAll(["auteur"=>$user->getAmis()->]);
        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
        ]);
    }
}
