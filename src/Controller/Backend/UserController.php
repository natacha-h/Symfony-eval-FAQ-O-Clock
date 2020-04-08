<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/** @Route("/admin", name="admin_user_") */
class UserController extends AbstractController
{
    
    /**
     * @Route("/user", name="index")
     */
    public function index(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        //récupération des users
        $users = $userRepository->findAll();
        return $this->render('backend/user/list.html.twig', [
            'users' => $users,
            'roles' => $roleRepository->findAll()
        ]);
    }

    /**
     * @Route("/user/{id}/status", name="change_status")
     */
    public function changeStatus(User $user, RoleRepository $roleRepository, EntityManagerInterface $em)
    {
        // récupération du role actuel
        $currentRole = $user->getRole()->getReference();
        // dd($currentRole);

        // si role actuel == ROLE_USER => on setRole ROLE_ADMIN
        if ('ROLE_USER' == $currentRole){
            $newRole = $roleRepository->findByReference('ROLE_MODERATEUR')[0];
            // dd($newRole);
            $user->setRole($newRole);
            // dd($user)

        } elseif ('ROLE_MODERATEUR' == $currentRole){
            $newRole = $roleRepository->findByReference('ROLE_USER')[0];
            // dd($newRole);
            $user->setRole($newRole);
            // dd($user);
        }
        // on persist et on lfush
        $em->persist($user);
        $em->flush();

        // ajout d'un flash message
        $this->addFlash(
            'success',
            'L\'utilisateur ' . $user->getUsername() . ' a maintenant les droits de : ' . $newRole->getName()
        );
        

        return $this->redirectToRoute('admin_user_index');
    }

}
