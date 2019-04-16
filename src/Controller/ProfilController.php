<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\ModifProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProfilController
 * @package App\Controller\Profil
 *
 * @Route("/profil")
 */

class ProfilController extends AbstractController
{
    /**
     * @Route("/{id}", defaults={"id": null})
     */
    public function index($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        if (is_null($id)) {
            $user = $this->getUser();
        } else {
            $user  = $manager->getRepository(User::class)->find($id);
        }

        $originalImage = null;

        if(!is_null($request->request->get('action'))){
            $article = new Article();
            //$article->setAuteur($this->getUser());

            $article->setAuteur($user);
            $article->setDatePublication(new \DateTime());
            if($request->request->get('action')!=-1){
                $id=intval($request->request->get('action'));
                $article = $manager->find(Article::class,$id);
                $originalImage = $article->getImage();
            }
        }else{
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()){
                $image = $article->getImage();
                if(!is_null($image)){
                    $newimage = uniqid().'.'.$image->guessExtension();
                    $image->move($this->getParameter('upload_dir'),$newimage);
                    $article->setImage($newimage);
                    if(!is_null($originalImage))unlink($this->getParameter('upload_dir').'/'.$originalImage);
                }else{
                    $article->setImage($originalImage);
                }
                $manager->persist($article);
                $manager->flush();

                $article = new Article();
                $form = $this->createForm(ArticleType::class,$article);
            }
        }

        return $this->render('profil/index.html.twig', ['user'=>$user,'formp'=>$form->createView()]);
    }


    /**
     * @Route("/edituser/{id}")
     */
    public function editUser(User $user, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        if (is_null($user)) {
            $user = $this->getUser();
        } else {
            $user = $manager->getRepository(User::class)->find($user);
        }

        $originalImage = null;


        $form = $this->createForm(ModifProfilType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if($form->isValid()) {
                $image = $user->getPhoto();
                if (!is_null($image)) {
                    $newimage = uniqid() . '.' . $image->guessExtension();
                    $image->move($this->getParameter('upload_dir'), $newimage);
                    $user->setPhoto($newimage);
                    if (!is_null($originalImage)) unlink($this->getParameter('upload_dir') . '/' . $originalImage);
                } else {
                    $user->setPhoto($originalImage);
                }
                $manager->persist($user);
                $manager->flush();

                $user = new User();
                $form = $this->createForm(ModifProfilType::class, $user);

                return $this->redirectToRoute('app_profil_index');
            }
        }

        return $this->render('profil/edituser.html.twig', ['user'=>$user,'formodif'=>$form->createView()]);
    }



    /**
     * id de l'article
     * @Route("/delete/{id}")
     */
    public function delete(Article $article){
        $manager = $this->getDoctrine()->getManager();

        if(!is_null($article->getImage())){
            unlink($this->getParameter('upload_dir')."/".$article->getImage());
        }

        $user=$article->getAuteur();
        $manager->remove($article);
        $manager->flush();
        //return $this->redirectToRoute('app_article_index',['id'=>$user->getId()]);
        return new Response("ok");
    }



}
