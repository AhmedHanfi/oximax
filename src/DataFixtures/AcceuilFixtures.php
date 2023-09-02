<?php

namespace App\DataFixtures;

use App\Entity\Acceuil;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AcceuilFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) { // Adjust the number of Acceuil entities as needed
            $acceuil = new Acceuil();
            $acceuil->setNom($faker->lastName());
            $acceuil->setPrenom($faker->firstName());
            $acceuil->setMail($faker->email());
            $acceuil->setTelephone($faker->phoneNumber());
            $acceuil->setAdress($faker->address());

            // Create and set a User for each Acceuil
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setRoles(['ROLE_ACCEUIL']);
            $encodedPassword = $this->userPasswordHasherInterface->hashPassword($user, 'password123'); // Set a default password
            $user->setPassword($encodedPassword);

            $user->setAcceuil($acceuil);
            $acceuil->setUser($user);

            $manager->persist($user);
            $manager->persist($acceuil);
        }

        $manager->flush();
    }

}
