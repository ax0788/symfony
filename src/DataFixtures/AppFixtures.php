<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName("Product One");
        $product->setDescription("First Product");
        $product->setSize(100);  // Be careful with case sensitivity!
        $manager->persist($product);

        $product = new Product();
        $product->setName("Product Two");
        $product->setDescription("Second Product");
        $product->setSize(200);
        $manager->persist($product);

        $manager->flush();
    }
}