<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/{id}")
     */
    public function index(Article $article)
    {
        $repository = $this->getDoctrine()->getRepository(Commentaire::class);
        // eq de findall() mais avec un tri sur le nom
        $commentaires = $repository->findBy(['article' => $article], ['datePublication' => 'DESC']);

        return $this->render('article/index.html.twig',
            [
                'commentaires' => $commentaires,
                'article' => $article
            ]);

        return $this->render('commentaire/index.html.twig');
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/modifier-commentaire/{id}", defaults={"id" : null}, requirements={"id" : "\d+"})
     */
    public function modifierCommentaire(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if(is_null($id)) { //creation
            $commentaire = new Commentaire();
        }else{
            // modification
            $commentaire = $em->find(Commentaire::class, $id);

            //404 si l'id recu exsiste pas en bdd
            if(is_null($commentaire)){
                throw new NotFoundHttpException();
            }
        }
        //creation du formulaire relie a la categorie
        $form = $this->createForm(CommentaireType::class, $commentaire);

        // le formulaire analyse la requete
        //et fait le mapping avec l'entite s'il a ete soumis
        $form->handleRequest($request);

        dump($commentaire);

        //si le formulaire a ete soumis
        if($form->isSubmitted()){
            //si les validations a partir des annotations dans
            // l'entite category sont ok
            if($form->isValid()) {
                //enregistrement da la categorie en bdd
                $em->persist($commentaire);
                $em->flush();

                $this->addFlash('success', 'le commentaire est enregistré');
                return$this->redirectToRoute('app_article_index', ['id' => $commentaire->getArticle()->getId()]);
            }else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render('commentaire/edit_commentaire.html.twig',
            [
                'form' => $form->createView()
            ]);
    }


    /**
     * @param Commentaire $commentaire
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("supprimer/{id}")
     */
    public function supprimerCommentaire(Commentaire $commentaire)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $commentaire->getArticle()->getId();
        $em->remove($commentaire);
        $em->flush();

        $this->addFlash('success', 'le commentaire est supprimé',
            [
                'id' => $id
            ]);
        return $this->redirectToRoute('app_article_index', ['id' => $commentaire->getArticle()->getId()]);
    }

}
