<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire")
     */
    public function index(Article $article)
    {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        // eq de findall() mais avec un tri sur le nom
        $commentaires = $repository->findBy(['article' => $article], ['publicationDate' => 'DESC']);

        return $this->render('admin/comment/index.html.twig',
            [
                'commentaires' => $commentaires,
                'article' => $article
            ]);

        return $this->render('commentaire/index.html.twig');
    }
}
