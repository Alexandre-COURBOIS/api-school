<?php

namespace App\DataFixtures;

use App\Entity\Ecole;
use App\Entity\Eleve;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @param EntityManagerInterface $em
     */
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        $eleve = new Eleve();

        for ($i = 0; $i <= 10; $i++) {

            $eleve = new Eleve();

            $eleve->setNom($faker->firstName);
            $eleve->setPrenom($faker->lastName);
            $eleve->setAge(rand(10,16));
            $eleve->setCreatedAt(new \DateTime());

            $manager->persist($eleve);

            for ($j = 0; $j <= 10; $j++) {

                $ecole = new Ecole();

                $ecole->setNom($faker->company);
                $ecole->setAdresse($faker->address);
                $ecole->setCreatedAt(new \DateTime());

            }

            $manager->persist($ecole);
        }

        $manager->flush();
    }
}
