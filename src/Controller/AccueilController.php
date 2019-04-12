<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/accueil")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/inscription")
     */
    public function inscription(Request $request,
                                UserPasswordEncoderInterface $passwordEncoder
    )
    {

        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);


        if($form->isSubmitted()){
            if($form->isValid()){
                //encode le mot de passe à partir de la config "encoders"
                //de config/packages/security.yaml
                $password = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );

                $user->setMotdepasse($password);

                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                $em->flush();

                $this->addFlash('success','Votre compte a été créé avec succés !');

                return $this->redirectToRoute('app_accueil_connexion');
            }else{
                $this->addFlash('error', 'Le formulaire contient des erreurs !');
            }
        }


        return $this->render('accueil/index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/connexion")
     */
    public function connexion(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error= $authenticationUtils->getLastAuthenticationError();
        $Prenom = $authenticationUtils->getLastUsername();
        dump($error);
        if(!empty($error)){
            dump($error);
            $this->addFlash('error', 'Identifiant incorrects !');
        }elseif ($request->isMethod('POST')) {
            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('accueil/connexion.html.twig',
            [
                'Prenom' => $Prenom
            ]
        );
    }

    /**
     * @Route("/deconnexion")
     */
    public function logout()
    {
        //Cette méthode peut rester vide, il faut juste que sa route existe
        // pour être passée dans la section logout de config/packages/security.yaml
    }
}
