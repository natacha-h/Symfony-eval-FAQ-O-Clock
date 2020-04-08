<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TagType;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;

;

/** @Route("/admin", name="admin_") */
class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag_index")
     */
    public function index(TagRepository $tagRepository)
    {
        //récupération des tags
        $tagList = $tagRepository->findAll();
        return $this->render('backend/tag/list.html.twig', [
            'tags' => $tagList,
        ]);
    }

    /**
     * @Route("/tag/new", name="tag_add")
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        // création de l'objet Tag
        $tag = new Tag();

        // création du formulaire
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($tag);
            $em->flush();

            // ajout d'un flash message
            $this->addFlash(
                'success',
                'Le tag a bien été ajouté'
            );

            // renvoie vers la liste des tags
            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('backend/tag/add.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/tag/{id}/edit", name="tag_edit", requirements={"id"="\d+"})
     */
    public function edit (Request $request, Tag $tag, EntityManagerInterface $em)
    {
        
        // création du formulaire
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($tag);
            $em->flush();

            // ajout d'un flash message
            $this->addFlash(
                'success',
                'Le tag a bien été modifié'
            );

            // renvoie vers la liste des tags
            return $this->redirectToRoute('admin_tag_index');
        }
        return $this->render('backend/tag/edit.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    
    /**
     * @Route("/tag/{id}/delete", name="tag_delete", requirements={"id"="\d+"})
     */
    public function delete (Tag $tag, EntityManagerInterface $em)
    {
        //suppression du tag
        $em->remove($tag);

        // enregistrement en bdd
        $em->flush();

        // Ajout d'un flash message
        $this->addFlash(
            'success',
            'Le Tag a bien été supprimé'
        );

        // redirige sur la liste des tags
        return $this->redirectToRoute('admin_tag_index');
    }
}
