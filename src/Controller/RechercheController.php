<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche")
     */
    public function rechercheAction(Request $request)

    {
        // pour recuperer les methode de repository
        //$repository contient une instance de app\repository\userRepository
        $repository = $this->getDoctrine()->getRepository(User::class);

        //la methode search dans UserRepository
        $users = $repository->search($request->request->get("recherchecontact"));

        return $this->render('recherche/index.html.twig',
        [
            'users' => $users
        ]);
    }

    /**
     * @Route("/recherche2/{name}")
     */
    public function rechercheAction2($name){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->search($name);

        return $this->render('recherche/dynamique.html.twig',
            [
                'users' => $users
            ]);
    }
}
