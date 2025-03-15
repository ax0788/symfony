<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductController extends AbstractController
{
/* Used ProductRepository Class to GET data and then display it from the database */
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $repository): Response
    {

        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll(),
        ]);
    }

/* Reading single Record from db  */
    #[Route('/product/{id<\d+>}', name: 'product_show')]

//we can put an object of the product entity class directly
 public function show(Product $product): Response
    {
       return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

}