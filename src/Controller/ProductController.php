<?php

namespace App\Controller;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Form\ProductType;   
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $repository): Response
    {
    //dump when you still want to see content
    //dd when you just want to see valus from db
    // $products = $repository->findAll();
    // dump($products);


        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll(),   
        ]);
    }

    // Displaying the Product with corresponding link from each id
    #[Route('/product/{id<\d+>}', name:'product_show')]
    public function create($id, ProductRepository $repository): Response
    {
        $product = $repository->find($id);

        if ($product === null) {
            throw $this->createNotFoundException('Product Not Found! ');
        }

        return $this->render('product/show.html.twig', [
            'product'=> $product
            ]);
    }

    #[Route('/product/new', name:'product_new')] 
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager-> persist($product);

            $manager->flush();

            //Displaying message
            $this->addFlash(
                'notice',
                'Product created succesfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id'=> $product->getId(),
                ]);
            // dd($product);

            // dd($request->request->all());
        }

        return $this->render('product/new.html.twig', [
            'form' => $form, 
        ]);
    }

    #[Route('/product/{id<\d+>}/edit', name:'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            //Displaying message
            $this->addFlash(
                'notice',
                'Product updated succesfully!'
            );

            return $this->redirectToRoute('product_show', [
                'id'=> $product->getId(),
                ]);

        }

        return $this->render('product/edit.html.twig', [
            'form' => $form, 
        ]);
    }

    #[Route('/product/{id<\d+>}/delete', name:'product_delete')]
    public function delete(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

        //Checks if the delete submit button is click
        if ($request->isMethod('POST')) {
            $manager->remove($product);
            $manager->flush();
        
            $this->addFlash(
                'notice',
                'Product deleted successfully!'
            );
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/delete.html.twig', [
            'id'=> $product->getId(),
            ]);
    }
}

