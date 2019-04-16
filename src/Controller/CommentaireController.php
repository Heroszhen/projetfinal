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

        $photo = $commentaire->getAuteur()->getPhoto();
        $image = (is_null($photo))?"http://miner8.com/en/wp-content/uploads/2017/06/Alexandra_Daddario_2016-e1497505927225.jpg":"{{asset('images/' ~ ".$photo.") }}";

        $r = "<div><div class=\"dropdown\"><small>À ".$commentaire->getDatePublication()->format('H:i d/m/Y')."</small><button class=\"btn btn-link dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"fas fa-certificate\"></i></button><div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\"><a class=\"dropdown-item\" href=\"#\">Modifier</a><a class=\"dropdown-item\" href=\"#\">supprimer</a></div></div><div class=\"vignette\"><img src=".$image." alt=''></div><br><strong><a href='{{ path(\"app_profil_index\",{ \"id\":response.id}) }}'>".$commentaire->getAuteur()->getPrenom()." ".$commentaire->getAuteur()->getNom()."</a></strong> a écrit : <span>".$commentaire->getContenu()."</span> <br><br></div>";
        return new Response($r);
    }

    /**
     * @Route("/delete/{id}")
     */
    public function delete(Commentaire $commentaire){
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($commentaire);
        $manager->flush();
        return new Response("ok");
    }

}
