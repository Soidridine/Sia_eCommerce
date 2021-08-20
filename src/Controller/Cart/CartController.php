<?php

namespace App\Controller\Cart;

use App\Services\CartServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $cartServices;

    public function __construct(CartServices $cartServices)
    {
        $this->cartServices = $cartServices;
    }
    
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        $cart = $this->cartServices->getFullCart();
        
        if (!isset($cart['products'])) {
            return $this->redirectToRoute('home');
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart
        ]);
    }

    /**
     * Undocumented function
     *
     * @Route("/cart/add/{id}", name="cart_add")
     * @param CartServices $cartServices
     * @return Response
     */
    public function addToCart($id): Response
    {
        $this->cartServices->addToCart($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * Undocumented function
     *
     * @Route("/cart/delete/{id}", name="cart_delete")
     * @return Response
     */
    public function deleteFromCart($id): Response
    {
        $this->cartServices->deleteFromCart($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * Undocumented function
     *
     * @Route("/cart/delete-all/{id}", name="cart_delete_all")
     */
    public function deleteAllToart($id): Response
    {
        $this->cartServices->deleteAllToCart($id);
        return $this->redirectToRoute('cart');
    }

}