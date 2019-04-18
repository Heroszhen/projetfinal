<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    /**
     * @Route("/photo")
     */
    public function index(Request $request)
    {

        //user connecte
        $user = $this->getUser();

        //*******************les photos
        //lien entre entite et bdd
        $em = $this->getDoctrine()->getManager();
        //instanciation
        $photo = new Photo();

        //creation du formulaire relie au commantaire
        $form = $this->createForm(PhotoType::class, $photo);

        // le formulaire analyse la requete
        //et fait le mapping avec l'entite s'il a ete soumis
        $form->handleRequest($request);

        //si le formulaire a ete soumis
        if($form->isSubmitted()){
            //si les validations a partir des annotations dans
            // l'entite category sont ok
            if($form->isValid()) {
                $photo->setUser($this->getUser());
                $photo->setDatePublication(new\DateTime());

                /**
                 * @var UploadedFile $image
                 */
                $image = $photo->getImage();
                // s'il y a eu une image uploadee
                if(!is_null($image)) {
                    // nom sous lequel on va enregistrer l'image
                    $filename = uniqid() . '.' . $image->guessExtension();

                    // deplacer l'image uploadée
                    $image->move(
                    // vers le repertoire /public/images
                    // cf config/ service.yaml
                        $this->getParameter('upload_dir'),
                        //nom du fichier
                        $filename
                    );

                    // on sette l'attribut image de l'article avec son nom pour enregistrement en bdd
                    $photo->setImage($filename);


                }

                //enregistrement da la photoo en bdd
                $em->persist($photo);
                $em->flush();

                $this->addFlash('success', 'la photo est enregistre');

                //return $this->redirectToRoute('app_article_index', [
                //    'id' => $article->getId()
                // ]); EQUI de

                return $this->redirectToRoute(
                    $request->get('_route'),
                    [
                        'id' => $photo->getId()
                    ]
                );
            }
        }

        // pour recuperer les methode de repository
        //$repository contient une instance de app\repository\userRepository
        $repository = $this->getDoctrine()->getRepository(Photo::class);
        // eq de findall() mais avec un tri sur le nom
        $photos = $repository->findBy(['user' => $user], ['datePublication' => 'DESC']);

        return $this->render('photo/index.html.twig',
            [
                'photos' => $photos,
                'user' => $user,
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/supprimer-photo/{id}")
     */
    public function supprimerPhoto(Photo $photo)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $photo->getId();
        //suppression de la bdd
        $em->remove($photo);
        $em->flush();
        
        // en modification on supprime l'ancienne image
        // s'il y en a une
        if(!is_null($photo)){
           unlink($this->getParameter('upload_dir') . $photo->getImage());
        }

        $this->addFlash('success', 'la photo est supprimée',
            [
                'id' => $id
            ]);
        return $this->redirectToRoute('app_photo_index', ['id' => $photo->getId() ]);
    }

}
