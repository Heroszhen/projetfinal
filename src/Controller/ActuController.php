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
     * @Route("/{id}", defaults={"id": null})
     */
    public function index(User $user, Request $request)
    {
        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
        ]);
    }
}
