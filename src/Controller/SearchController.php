<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);


        //formulaire de recherche
        $searchForm = $this->createForm(SearchType::class);

        $searchForm->handleRequest($request);

        dump($searchForm->getData());

        $users = $repository->search((array)$searchForm->getData());

        return $this->render('search/index.html.twig', [
            'users' => $users,
            'search_form' =>$searchForm->createView()
        ]);
    }
}
