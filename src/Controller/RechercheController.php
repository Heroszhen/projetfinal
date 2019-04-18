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
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        if($request->isMethod('POST')){
            $nom = $request->get('nom');
            $users = $em->getRepository(User::class)->findBy(['nom'=> $nom]);

            return $this->redirectToRoute('app_recherche_recherche',
            [
                'users' => $users
            ]);
        }

        return $this->render('recherche/index.html.twig',
        [
            'users' => $users
        ]);
    }
}
