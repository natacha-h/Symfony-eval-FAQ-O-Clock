<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TagRepository;
use App\Entity\Tag;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{id}/questions", name="tag_show_questions", requirements={"id"="\d+"})
     */
    public function showQuestionsByTag(Tag $tag, TagRepository $tagRepository)
    {
        // récupération des questions liées au tag
        $questions = $tag->getQuestions();
        // dd($questions);
        
        return $this->render('/tag/show_question.html.twig', [
            'tag' => $tag,
            'tags' => $tagRepository->findAll(),
            'questions' => $questions          
        ]);
    }

    
}
