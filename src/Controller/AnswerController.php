<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnswerRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\QuestionRepository;

class AnswerController extends AbstractController
{
    
    /**
     * @Route("/answer/question/{id}", name="answer_new", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function new(Request $request, EntityManagerInterface $em, $id, QuestionRepository $questionRepository)
    {
        // on vérifie si l'utilisateur existe en BDD (= est connecté)
        $user = $this->getUser();
        // dd($user);
        if (null == $user){ // si $this->getUser renvoie null
            // on ajoute un flash message
            $this->addFlash(
                'danger',
                'Vous devez être connecté pour répondre'
            );

            // on redirige vers la page de login
            return $this->redirectToRoute('app_login');


        } else { // sinon on continue l'action normalement
    
            // dd($request);
            // je fais mon formulaire et je récupères les données à la main pour que ma fonction addAnswer soit gérée par le AnswerController
            // je déclare l'objet à créer
            $newAnswer = new Answer();
            
            // récupération de l'objet Question lié à la réponse
            $question = $questionRepository->findById($id);
            // dd($question[0]);
            
            // récupération des données du formulaires
            $newAnswer->setContent($request->request->get('answer'));
            $newAnswer->setAuthor($this->getUser());
            $newAnswer->setQuestion($question[0]);
            
            // persist
            $em->persist($newAnswer);
            //flush
            $em->flush();
            
            // ajout du flash message
            $this->addFlash(
                'success',
                'Votre réponse a bien été enregistrée'
            );
            
            // on redirige vers la page de la question
            return $this->redirectToRoute('question_show', [
                'id' => $id
                ]);
                
        }
    }

    /**
     * @Route("/answer/{id}/validate", name="answer_validate", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function answerValidate(Answer $answer, EntityManagerInterface $em)
    {
        
        $validator = $answer->getQuestion()->getAuthor();

        // si l'utilisateur n'est pas connecté ou n'est pas l'auteur
        if( (null == $this->getUser()) || ($validator->getId() !== $this->getUser()->getId())) {
            // Flash Message
            $this->addFlash(
                'warning',
                'Seul l\'auteur de la question peut valider une réponse'
            );
        } else { // sinon c'est l'auteur  => il est autorisé
         
            //on passe le champ "isValid" de 0 à 1
                $answer->setIsValid(true);
                // dump($answer);die;
    
                // on enregistre en BDD
                $em->persist($answer);
                $em->flush();
    
                // Flash Message
                $this->addFlash(
                    'success',
                    'Vous avez validé la réponse de' . $answer->getAuthor()->getUsername()
                );
        }

        // redirection sur la page de la question
        return $this->redirectToRoute('question_show', [
            'id' => $answer->getQuestion()->getId()
        ]);
        
    }



}
