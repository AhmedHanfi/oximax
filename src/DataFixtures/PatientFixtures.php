<?php

namespace App\DataFixtures;

use App\Entity\Docteur;
use App\Entity\DocteurPatientLigne;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PatientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create 200 patients
        for ($i = 0; $i < 200; $i++) {
            $patient = new Patient();
            $patient->setDateNaissance($faker->dateTimeBetween('-80 years', '-1 years'));
            $patient->setTelephone($faker->phoneNumber());
            $patient->setNom($faker->lastName());
            $patient->setPrenom($faker->firstName());
            $patient->setGenre($faker->randomElement(['Mr', 'Mme']));
            $patient->setNumidentite($faker->numberBetween(1000000, 9999999));
            $patient->setAdress($faker->address());
            $patient->setMail($faker->email());
            $patient->setEtatPatient($faker->text());

            $manager->persist($patient);
        }
        $manager->flush();

        // Get all doctors and patients from the database
        $doctors = $manager->getRepository(Docteur::class)->findAll();
        $patients = $manager->getRepository(Patient::class)->findAll();

        // Assign doctors to random patients
        foreach ($doctors as $doctor) {
            $randomPatient = $faker->randomElement($patients);

            // Create a new DocteurPatientLigne entity
            $docteurPatientLigne = new DocteurPatientLigne();
            $docteurPatientLigne->setDocteur($doctor);
            $docteurPatientLigne->setPatient($randomPatient);

            // Persist the DocteurPatientLigne entity
            $manager->persist($docteurPatientLigne);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [DocteurFixtures::class];
    }
}
