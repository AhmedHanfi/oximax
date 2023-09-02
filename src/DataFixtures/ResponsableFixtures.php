<?php

namespace App\DataFixtures;

use App\Entity\Responsable;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResponsableFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            $responsable = new Responsable();
            $responsable->setNom($faker->lastName());
            $responsable->setPrenom($faker->firstName());
            $responsable->setMail($faker->email());
            $responsable->setTelephone($faker->phoneNumber());
            $responsable->setAdress($faker->address());

            // Create and set a User for each Responsable
            $user = new User();
            $user->setUsername($faker->userName());
            $user->setRoles(['ROLE_RESPONSABLE']);
            $encodedPassword = $this->userPasswordHasherInterface->hashPassword($user, 'password123'); // Set a default password
            $user->setPassword($encodedPassword);

            $user->setResponsable($responsable);
            $responsable->setUser($user);

            $manager->persist($user);
            $manager->persist($responsable);
        }

        $manager->flush();
    }

}
