<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
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
    public function index(User $user, Request $request, Article $article)
    {
        //les commentaires
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();

        //creation du formulaire relie au commantaire
        $form = $this->createForm(CommentaireType::class, $commentaire);

        // le formulaire analyse la requete
        //et fait le mapping avec l'entite s'il a ete soumis
        $form->handleRequest($request);

        dump($article);

        //si le formulaire a ete soumis
        if($form->isSubmitted()){
            //si les validations a partir des annotations dans
            // l'entite category sont ok
            if($form->isValid()) {
                $commentaire->setAuteur($this->getUser());
                $commentaire->setDatePublication(new\DateTime());
                $commentaire->setArticle($article);

                //enregistrement da la categorie en bdd
                $em->persist($commentaire);
                $em->flush();

                $this->addFlash('success', 'le commentaire est enregistre');

                //return $this->redirectToRoute('app_article_index', [
                //    'id' => $article->getId()
                // ]); EQUI de

                return $this->redirectToRoute(
                    $request->get('_route'),
                    [
                        'id' => $article->getId()
                    ]
                );
            }
        }
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        // eq de findall() mais avec un tri sur le nom
        $commentaires = $repository->findBy(['article' => $article], ['datePublication' => 'DESC']);

        return $this->render('article/index.html.twig',
            [
                'user'=>$user,
                'form' => $form->createView(),
                'article' => $article,
                'commentaires' => $commentaires
            ]);
    }

    /**
     * @Route("/edit/{id}",defaults={"id":null})
     */
    public function editArticle(){

    }
}
