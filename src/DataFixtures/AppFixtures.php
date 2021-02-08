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
        $nfactory->setNom("Nfactory");
        $nfactory->setAdresse('28 Place Saint-Marc, 76000 Rouen');
        $nfactory->setCreatedAt(new \DateTime());
        $manager->persist($nfactory);

        $bci2 = new Classe();
        $bci2->setNom("2BCI");
        $bci2->setEcole($nfactory);
        $manager->persist($bci2);

        $iscom = new Ecole();
        $iscom->setNom("ISCOM");
        $iscom->setAdresse("24 Place Saint-Marc, 76000 Rouen");
        $iscom->setCreatedAt(new \DateTime());
        $manager->persist($iscom);

        $umsa = new Ecole();
        $umsa->setNom("Université Mont Saint Aignan");
        $umsa->setAdresse("1 Rue Thomas Becket, 76130 Mont-Saint-Aignan");
        $umsa->setCreatedAt(new \DateTime());
        $manager->persist($umsa);

        $manager->flush();
    }
}
