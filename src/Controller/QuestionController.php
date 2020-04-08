<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use App\Repository\TagRepository;
use App\Entity\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\QuestionType;
use App\Form\AnswerType;


class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="question_list")
     */
    public function index(QuestionRepository $questionRepository, TagRepository $tagRepository)
    {
        // récupération de la liste des questions
        $questionList = $questionRepository->findAllByCreatedAt();

        // récupération des tags pour affichage sur la page d'accueil
        $tags = $tagRepository->findAll();
        return $this->render('question/list.html.twig', [
            'questions' => $questionList,
            'tags' => $tags
        ]);
    }
    /**
     * @Route("/question/{id}", name="question_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Question $question = null): Response
    {
        // on vérifie si la question existe
        if (!$question) {
            throw $this->createNotFoundException('La question est introuvable');
        }
        // dd($question);
        // renvoie la question

        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/question/new", name="question_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        // // on vérifie si l'utilisateur existe en BDD (= est connecté)
        $user = $this->getUser();
        // dd($user);

        if (null == $user){ // si $this->getUser renvoie null
            // on ajoute un flash message
            $this->addFlash(
                'danger',
                'Vous devez être connecté pour poser une question'
            );

            // on redirige vers la page de login
            return $this->redirectToRoute('app_login');


        }  else { // sinon on continue l'action normalement

            // création de l'objet à récuperer
            $question = new Question();

            // création du formulaire
            $form = $this->createForm(QuestionType::class, $question);
            //dump($question);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // on ajoute l'auteur à la question
                $question->setAuthor($user);
                //dump($question);
                // on persist la question
                $em->persist($question);

                //on flush
                $em->flush();

                // Ajout d'un FlashMessage
                $this->addFlash(
                    'success',
                    'Votre question a bien été posée'
                );

                // on redirige vers la liste des questions
                return $this->redirectToRoute('question_list');
            }
            

            return $this->render('question/new.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
    
}
