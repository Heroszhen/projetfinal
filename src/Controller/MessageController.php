<?php

namespace App\Controller;

use App\Entity\Amis;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        $repository = $this->getDoctrine()->getRepository(Amis::class);
        $amis = $repository->findBy(["suiveur"=>$this->getUser()], ['id' => 'ASC']);
        return $this->render(
            'message/index.html.twig',
            [
            'amis' => $amis,
            ]);
    }

    /**
     * @Route("/user/{id}-{id2}",defaults={"id2":""})
     */
    public function message($id,$id2)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(["id"=>$id]);
        $messages = $em->getRepository(Message::class)->search($this->getUser(), $user,$id2);

        return $this->render(
            'message/message-discussion.html.twig',
            [
                'messages' => $messages,
            ]);
    }

    /**
     * @Route("/addmessage/{id}-{mymessage}")
     */
    public function add($id,$mymessage){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(["id"=>$id]);
        $message = new Message();
        $message->setAuteur($this->getUser());
        $message->setDestinataire($user);
        $message->setContenu($mymessage);
        $message->setDatePublication(new \DateTime());
        $em->persist($message);
        $em->flush();
        return new Response("ok");
    }
}
