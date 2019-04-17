<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/actu")
 */
class ActuController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function index()
    {

        $user = new User();


        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
        ]);
    }
}
