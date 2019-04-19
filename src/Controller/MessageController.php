<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 * @package App\Controller
 *
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findBy([], ['id' => 'ASC']);
        $hasUser = $this->getUser();


        return $this->render(
            'message/index.html.twig',
            [
            'users' => $users,
            ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/{id}")
     */
    public function message(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Message::class);
        $messages = $repository->search($this->getUser(), $user);

        return $this->render(
            'message/message-discussion.html.twig',
            [
                'messages' => $messages,
            ]);
    }
}
