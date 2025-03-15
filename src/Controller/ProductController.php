<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;




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
//we can put an object of the product entity class directly
 #[Route('/product/{id<\d+>}', name: 'product_show')]
 public function show(Product $product): Response
    {
       return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

 #[Route('/product/new', name: 'product_new')]
 public function new(Request $request, EntityManagerInterface $manager): Response
    {

// We assign values from the form to a Product Entity Object 

// 1. Create new object of Product Entity class
$product = new Product;

// 2. Pass that object as the 2nd arguement for the Form method
$form = $this->createForm(ProductType::class, $product);

// 3. Save the object to the database ^

$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()){

// 4. Call persist method on entitymanager object, and then pass in product entity object
$manager->persist($product);

// 5. Call flush method to actually save to the database
$manager->flush();

// Flash messages
$this->addFlash(
'notice',
'Product created successfully!',
);

// 6. Print out product entity object
// 
// 7.redirectToRoute METHOD of the controller, and getId method of the product entity
  return $this->redirectToRoute('product_show',[
'id' => $product->getId(),
]);
    }


       return $this->render('product/new.html.twig',[
'form' => $form,
]);
    }



  #[Route('/product/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {


$form = $this->createForm(ProductType::class, $product);


$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()){


$manager->flush();

$this->addFlash(
'notice',
'Product updated successfully!',
);

  return $this->redirectToRoute('product_show',[
'id' => $product->getId(),
]);
    }


       return $this->render('product/edit.html.twig',[
'form' => $form,
]);

    }



  #[Route('/product/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
if($request->isMethod('POST')){
$manager->remove($product);
$manager->flush();
$this->addFlash(
'notice',
'Product Deleted Successfully!'
);
return $this->redirectToRoute('product_index');
}

       return $this->render('product/delete.html.twig',[
'id' => $product->getId(),
]);

    }


}