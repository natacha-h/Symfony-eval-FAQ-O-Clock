<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{id}/profile", name="user_profile", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(User $user)
    {
        
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="user_profile_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, User $user)
    {
        dump($user);
        // récupération de l'ancien password du user
        $oldPassword = $user->getPassword();
        dump($oldPassword);

        // création du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request); // va remplacer la valeur du password par null si je ne le modifie pas
        dump($user->getPassword());
        if ($form->isSubmitted() && $form->isValid()) {
            
            // si la valeur de password est null, je garde l'ancien
            if (empty($user->getPassword())) {
                
                $encodedPassword = $oldPassword;
                // dd($encodedPassword);
            } // sinon si je change de password je l'encode
            else {
                $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                // dd($encodedPassword);
            }

            // je set le password encodé à mon $user
            $user->setPassword($encodedPassword);

            // je persist le user
            $em->persist($user);
            // je flush le user
            $em->flush();

            // ajout d'un FlashMessage
            $this->addFlash(
                'success',
                'Les changements ont bien été eregistrés'
            );

            // je redirige vers le profil user 
            return $this->redirectToRoute('user_profile', [
                'id' => $user->getId() // passer à la vue l'id (obligatoire pour afficher la page)
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        // je déclare l'objet que je vais devoir récupérer
        $user = new User();

        // création du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request); // va remplacer la valeur du password par null si je ne le modifie pas

        if ($form->isSubmitted() && $form->isValid()) {
            
            // j'encore le password reçu
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                
            // je set le password encodé à mon $user
            $user->setPassword($encodedPassword);

            // je persist le user
            $em->persist($user);
            // je flush le user
            $em->flush();

            // ajout d'un FlashMessage
            $this->addFlash(
                'success',
                'Votre compte a bien été créé. Connectez-vous'
            );

            // je redirige vers le profil user 
            return $this->redirectToRoute('question_list');
        }

        

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
