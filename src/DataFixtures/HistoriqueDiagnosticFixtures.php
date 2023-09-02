<?php

namespace App\DataFixtures;

use App\Entity\Diagnostic;
use App\Entity\HistoriqueDiagnostic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class HistoriqueDiagnosticFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $diagnostics = $manager->getRepository(Diagnostic::class)->findAll();

        foreach ($diagnostics as $diagnostic) {

            $numHistoryEntries = random_int(1, 5);

            for ($i = 0; $i < $numHistoryEntries; $i++) {
                $hasHistory = $faker->boolean(50);

                if ($hasHistory) {
                    // Simulate changes in the diagnostic
                    $historiqueDiagnostic = new HistoriqueDiagnostic();
                    $historiqueDiagnostic->setDiagnostic($diagnostic);

                    $creationDate = $diagnostic->getDateCreaction();
                    $randomDays = random_int(1, 10);
                    $dateEdit = clone $creationDate;
                    $dateEdit->modify('-' . $randomDays . ' days');
                    $historiqueDiagnostic->setDateEdit($dateEdit);

                    $historiqueDiagnostic->setMaladie($diagnostic->getMaladie());
                    $historiqueDiagnostic->setDescription($faker->paragraph(1));
                    $historiqueDiagnostic->setPrescription($faker->sentence());
                    $historiqueDiagnostic->setEtat($faker->randomElement(['amélioration', 'déterioration']));

                    $manager->persist($historiqueDiagnostic);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [DiagnosticsFixtures::class];
    }
}
