<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnswerRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Answer;
use App\Form\AnswerType;
use Doctrine\ORM\EntityManagerInterface;

/** @Route("/admin", name="admin_answer_") */
class AnswerController extends AbstractController
{
    /**
     * @Route("/answer", name="index")
     */
    public function index(AnswerRepository $answerRepository)
    {
        //récupération des réponses
        $answerList = $answerRepository->findAll();
        return $this->render('backend/answer/list.html.twig', [
            'answers' => $answerList,
        ]);
    }

    /**
     * // méthode pour bloquer/débloquer une réponse
     * @Route("/answer/{id}/status", name="status", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function changeStatus(Answer $answer, EntityManagerInterface $em)
    {
        // dd($answer);
        // On change la valeur is_active de la question
        if (true == $answer->getIsActive()){ // si la valeur actuelle est true
            $answer->setIsActive(false); // on passe à false
        } else { // sinon
            $answer->setIsActive(true); // on passe à true
        }
        // dd($answer);

        $em->persist($answer);
        $em->flush();

        return $this->redirectToRoute('question_show', [
            'id' => $answer->getQuestion()->getId()
        ]);
    }
    
}
