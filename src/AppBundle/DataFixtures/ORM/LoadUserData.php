<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null) 
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($userAdmin, 'admin_password');

        $userAdmin->setUsername('Admin');
        $userAdmin->setPassword($password);
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $userAdmin->setIsActive(1);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}