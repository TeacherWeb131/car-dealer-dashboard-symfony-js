<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // Owner possède des Cars
        for ($o = 0; $o <= 3; $o++) {
            $owner = new Owner();
            $owner->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhone($faker->phoneNumber);
            $manager->persist($owner);

            // Car est possédée par un Owner
            for ($c = 0; $c < 4; $c++) {
                $car = new Car();

                // Boucler sur le tableau de marque de façon aléatoire
                $brandArray = ["Peugeot", "Renault", "Citroen", "Toyota"];
                $brandArrayRandKey = array_rand($brandArray, 1);

                $car->setBrand($brandArray[$brandArrayRandKey])
                    ->setModel("Model " . $c)
                    ->setCategory("Categorie " . $c)
                    ->setYear(rand(1990, 2019))
                    ->setMilage(rand(0, 120000))
                    ->setPrice(rand(2000, 15000))
                    //la ligne ci-dessous dit : Voila le Owner auquel je lie cette Car que je suis en train de créer
                    ->setOwner($owner);
                $manager->persist($car);
            }
            $manager->flush();
        }
    }
}
