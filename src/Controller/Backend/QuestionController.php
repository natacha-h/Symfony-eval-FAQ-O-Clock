<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;


/** @Route("/admin", name="admin_question_") */
class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="index")
     */
    public function index(QuestionRepository $questionRepository)
    {
        //récupération des questions
        $questionList = $questionRepository->findAllByCreatedAt();
        return $this->render('question/index.html.twig', [
            'questions' => $questionList,
        ]);
    }

    /**
     * // méthode pour bloquer/débloquer une question
     * @Route("/question/{id}/status", name="status", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function changeStatus(Question $question, EntityManagerInterface $em)
    {
        // dump($question);
        // On change la valeur is_active de la question
        if (true == $question->getIsActive()){ // si la valeur actuelle est true
            $question->setIsActive(false); // on passe à false
        } else { // sinon
            $question->setIsActive(true); // on passe à true
        }
        // dd($question);

        $em->persist($question);
        $em->flush();

        return $this->redirectToRoute('question_list');
    }
}
