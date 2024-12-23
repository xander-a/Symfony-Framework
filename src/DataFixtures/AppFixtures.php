<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Make this based on tables from database
        $product = new Product;
        $product->setName("Product One: ");
        $product->setPrice(100);
        
        $manager->persist($product);

        $product = new Product;
        $product->setName("Product Two: ");
        $product->setPrice(100);
        $manager->persist($product);

        //Loading the data into the database
        $manager->flush();


        
    }
}
