<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\HomeSliderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $product, HomeSliderRepository $repoHomeSlider): Response
    {
        $products = $product->findAll();
        $homeSlider = $repoHomeSlider->findBy(['isDisplayed' => true]);
        $productBestSeller = $product->findByIsBestSeller(1); // Affiche tous les produits dont le Best Seller est a 1 (true)
        $productSpecialOffer = $product->findByIsSpecialOffer(1);
        $productNewArrival = $product->findByIsNewArrival(1);
        $productFeatured = $product->findByIsFeatured(1);

        //dd($productBestSeller,$productSpecialOffer,$productNewArrival,$productFeatured);
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
            'productFeatured' => $productFeatured,
            'productBestSeller' => $productBestSeller,
            'productNewArrival' => $productNewArrival,
            'productSpecialOffer' => $productSpecialOffer,
            'homeSlider' => $homeSlider,
        ]);
    }

    /**
     * Affiche le details d'un produit
     *
     * @Route("product/{slug}", name="product_details")
     * 
     * @param Product|null $product
     * @return Response
     */
    public function show(?Product $product): Response
    {
        if (!$product) {
            return $this->redirectToRoute('home');
        }

        return $this->render("home/single_product.html.twig", [
            'product' => $product
        ]);
    }

    /**
     * @Route("/shop", name="shop")
     */
    public function shop(ProductRepository $product): Response
    {
        $products = $product->findAll();
        return $this->render('home/shop.html.twig', [
            'products' => $products,
        ]);
    }
}