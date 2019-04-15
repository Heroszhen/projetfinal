<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/ajout/{id}")
     */
    public function index(Request $request, Article $article)
    {
        $commentaire = new Commentaire();
        $commentaire->setContenu($request->request->get('commentaire'));
        $commentaire->setAuteur($this->getUser());
        $commentaire->setDatePublication(new \DateTime());
        $commentaire->setArticle($article);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($commentaire);
        $manager->flush();
        /*
        $array = [
        'timepublication'=>$commentaire->getDatePublication()->format('H:i d/m/Y'),
        'id'=>$commentaire->getAuteur()->getId(),
        'prenom'=>$commentaire->getAuteur()->getPrenom(),
        'nom'=>$commentaire->getAuteur()->getNom(),
        'contenu'=>$commentaire->getContenu()
    ];*/
        $r = "<div><small>À ".$commentaire->getDatePublication()->format('H:i d/m/Y')."</small><br><div class=\"vignette\"><img src='' alt=''></div><br><strong><a href='{{ path(\"app_profil_index\",{ \"id\":response.id}) }}'>".$commentaire->getAuteur()->getPrenom()." ".$commentaire->getAuteur()->getNom()."</a></strong> a écrit : ".$commentaire->getContenu()." <br></div><br>";
        return new Response($r);
    }


}
