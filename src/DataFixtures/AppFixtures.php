<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Ecole;
use App\Entity\Eleve;
use App\Repository\ClasseRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        $classe = new Classe();
        $classe->setNom("2BCI");


        for ($i = 0; $i <= 10; $i++) {

            $eleve = new Eleve();

            $eleve->setNom($faker->firstName);
            $eleve->setPrenom($faker->lastName);
            $eleve->setAge(rand(10, 16));
            $eleve->setCreatedAt(new \DateTime());

            $manager->persist($eleve);

            $ecole = new Ecole();

            $ecole->setNom($faker->company);
            $ecole->setAdresse($faker->address);
            $ecole->setCreatedAt(new \DateTime());

            $classe->setEcole($ecole);

            $manager->persist($ecole);
            $manager->persist($classe);

        }

        $manager->flush();
    }
}
