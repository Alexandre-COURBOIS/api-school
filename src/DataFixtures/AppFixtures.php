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
        $nfactory = new Ecole();
        $nfactory->setNom("NFactory");
        $nfactory->setAdresse("28 Place Saint-Marc, 76000 Rouen");
        $nfactory->setCreatedAt(new \DateTime());
        $manager->persist($nfactory);

        $bci2 = new Classe();
        $bci2->setNom("2BCI");
        $bci2->setEcole($nfactory);
        $manager->persist($bci2);

        for ($i = 0; $i < 3; $i++){
            $eleve = new Eleve();
            $eleve->setNom("Olivier$i");
            $eleve->setPrenom("Dupont$i");
            $eleve->setAge(10 + $i);
            $eleve->setClasse($bci2);
            $eleve->setCreatedAt(new \DateTime());
            $manager->persist($eleve);
        }

        $bci3 = new Classe();
        $bci3->setNom("3BCI");
        $bci3->setEcole($nfactory);
        $manager->persist($bci3);

        for ($i = 0; $i < 2; $i++){
            $eleve = new Eleve();
            $eleve->setNom("Jean$i");
            $eleve->setPrenom("Baptiste$i");
            $eleve->setAge(10 + $i);
            $eleve->setClasse($bci3);
            $eleve->setCreatedAt(new \DateTime());
            $manager->persist($eleve);
        }

        $iscom = new Ecole();
        $iscom->setNom("ISCOM");
        $iscom->setAdresse("24 Place Saint-Marc, 76000 Rouen");
        $iscom->setCreatedAt(new \DateTime());
        $manager->persist($iscom);

        $umsa = new Ecole();
        $umsa->setNom("Universite Mont Saint Aignan Rouen");
        $umsa->setAdresse("1 Rue Thomas Becket, 76130 Mont-Saint-Aignan");
        $umsa->setCreatedAt(new \DateTime());
        $manager->persist($umsa);

        $manager->flush();
    }
}
