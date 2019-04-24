<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Entity\Resultatquizz;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuizzController extends AbstractController
{
    /**
     * @Route("/quizz")
     */
    public function index()
    {
        $zhen="";
        $repository = $this->getDoctrine()->getRepository(Resultatquizz::class);
        $zhen = $repository->findOneBy(['user'=>$this->getUser()]);
        if ($zhen!= "")$completer=true;
        else $completer=false;
        $repository = $this->getDoctrine()->getRepository(Quizz::class);
        $questions = $repository->findBy([], ['id' => 'ASC']);
        $repository = $this->getDoctrine()->getRepository(Resultatquizz::class);
        $classements = $repository->findBy([], ['score' => 'DESC']);
        return $this->render('quizz/index.html.twig',
            [
                'questions' => $questions,
                'completer' => $completer,
                'classements' => $classements
            ]);
    }

    /**
     *@Route("/resultat/{score}")
     */
    public function resultat($score)
    {
        $resultatquizz = new Resultatquizz();
        $resultatquizz->setUser($this->getUser());
        $resultatquizz->setScore($score);
        $resultatquizz->setDate(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($resultatquizz);
        $em->flush();
        return $this->render('quizz/resultat.html.twig',
            [
                'completer' => true
            ]);
    }
}
