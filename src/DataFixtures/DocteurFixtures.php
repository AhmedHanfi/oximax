<?php

namespace App\DataFixtures;

use App\Entity\Docteur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DocteurFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $docteur = new Docteur();
            $docteur->setNom($faker->lastName());
            $docteur->setPrenom($faker->firstName());
            $docteur->setSpecialite($faker->word());
            $docteur->setTelephone($faker->phoneNumber());
            $docteur->setMail($faker->email());
            $docteur->setAdress($faker->address());
            $docteur->setCabinet($faker->company());

            // Create and set a User for each Docteur
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setRoles(['ROLE_DOCTOR']);
            $encodedPassword = $this->userPasswordHasherInterface->hashPassword($user, 'password123');
            $user->setPassword($encodedPassword);

            $docteur->setUser($user);
            $user->setDocteur($docteur);

            $manager->persist($user);
            $manager->persist($docteur);
        }

        $manager->flush();
    }
}
