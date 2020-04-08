<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\Tag;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // DONNÉES FIXES => Je crée mes users et leur rôle à la main pour leur données la valeur que je veux
        
        //user
        $roleUser = new Role();
        $roleUser->setReference('ROLE_USER');
        $roleUser->setName('Utilisateur');
        
        // admin
        $roleAdmin = new Role();
        $roleAdmin->setReference('ROLE_ADMIN');
        $roleAdmin->setName('Administrateur');

        // modo
        $roleModo = new Role();
        $roleModo->setReference('ROLE_MODERATEUR');
        $roleModo->setName('Modérateur');

        $user = new User();
        $user->setUsername('user');
        //encodage du password avant de le passer en bdd
        $encodedPassword = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($encodedPassword);
        $user->setEmail('user@o.io');
        $user->setRole($roleUser);

        $admin = new User();
        $admin->setUsername('admin');
        $encodedPassword = $this->encoder->encodePassword($admin, 'admin');
        $admin->setPassword($encodedPassword);
        $admin->setEmail('admin@o.io');
        $admin->setRole($roleAdmin);

        $modo = new User();
        $modo->setUsername('modo');
        $encodedPassword = $this->encoder->encodePassword($modo, 'modo');
        $modo->setPassword($encodedPassword);
        $modo->setEmail('modo@o.io');
        $modo->setRole($roleModo);

        // Je persist mes roles pour qu'ils existent déjà en bdd au moment où je vais persister mes users
        $manager->persist($roleUser);
        $manager->persist($roleAdmin);
        $manager->persist($roleModo);

        $manager->persist($user);
        $manager->persist($admin);
        $manager->persist($modo);

        // Génération des données aléatoires par Alice

        $loader = new NativeLoader();

        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__.'/fixtures.yml')->getObjects();
        
        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
