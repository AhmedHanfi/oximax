<?php

namespace App\DataFixtures;

use App\Entity\Diagnostic;
use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DiagnosticsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Create diagnostics for patients
        $patients = $manager->getRepository(Patient::class)->findAll();

        foreach ($patients as $patient) {

            $diagnostic = new Diagnostic();

            $diagnostic->setMaladie($faker->randomElement([
                "Diabète",
                "Hypertension (Pression artérielle élevée)",
                "Cancer",
                "Maladie cardiaque",
                "Accident vasculaire cérébral (AVC)",
                "Maladie d'Alzheimer",
                "Arthrite",
                "Asthme",
                "Maladie pulmonaire obstructive chronique (MPOC)",
                "Grippe (Influenza)",
                "Pneumonie",
                "Ostéoporose",
                "VIH/SIDA",
                "Hépatite",
                "Paludisme",
                "Tuberculose (TB)",
                "Maladie de Parkinson",
                "Sclérose en plaques",
                "Épilepsie",
                "Trouble du spectre de l'autisme (TSA)",
                "Schizophrénie",
                "Dépression",
                "Troubles anxieux",
                "Trouble obsessionnel-compulsif (TOC)",
                "Trouble bipolaire",
                "Polyarthrite rhumatoïde",
                "Maladie de Crohn",
                "Syndrome de l'intestin irritable (SII)",
                "Insuffisance rénale chronique",
                "Syndrome de fatigue chronique (SFC)"
            ]
        ));
            $diagnostic->setDescription($faker->paragraph(1));
            $diagnostic->setPrescription($faker->sentence());
            $diagnostic->setPatient($patient);
            $diagnostic->setEtat($faker->randomElement(['amélioration', 'déterioration']));
            $diagnostic->setDateCreaction($faker->dateTimeBetween('-3 year', 'now'));

            $manager->persist($diagnostic);

        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [PatientFixtures::class];
    }
}
