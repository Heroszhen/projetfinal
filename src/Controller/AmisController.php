<?php

namespace App\Controller;

use App\Entity\Amis;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/amis")
 */
class AmisController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function index(User $user)
    {
        return $this->render('amis/index.html.twig',
                [
                    'user' => $user
                ]

            );
    }



    /**
     * @Route("/{id}")
     */
    public function follow(User $amis)
    {
        $amis = new Amis();
        $amis->setSuivi($amis);
        $amis->setSuiveur($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($amis);
        $em->flush();

        return new Response('Confirmation de suivi');
    }

    /**
     * @Route("/{id}")
     */
    public function unflollow(Amis $amis)
    {

        $em = $this->getDoctrine()->getManager();

        if(!is_null($amis->getId())){

            $em->remove($amis);
        }

        $em->flush();

        return new Response('Vous n\'êtes plus amis :(' );

    }
}
