<?php

namespace App\Controller;

use App\Entity\Amis;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $repository = $this->getDoctrine()->getRepository(Amis::class);
        $listeAmis= $repository->findBy(['user'=>$user], ['prenom'=> 'desc']);


        return $this->render('amis/index.html.twig',
                [
                    'amis' => $user
                ]
            );
    }
}
