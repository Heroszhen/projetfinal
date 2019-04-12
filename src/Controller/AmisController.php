<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class AmisController extends AbstractController
{
    /**
     * @Route("/amis")
     */
    public function index()
    {
        return $this->render('amis/index.html.twig', [
            'controller_name' => 'AmisController',
        ]);
    }
}
