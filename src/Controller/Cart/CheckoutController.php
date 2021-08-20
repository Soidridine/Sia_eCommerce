<?php

namespace App\Controller\Cart;

use App\Form\CheckoutType;
use App\Services\CartServices;
use App\Services\OrderServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $cartServices;

    private $session;
    
    public function __construct(CartServices $cartServices, SessionInterface $session)
    {
        $this->cartServices = $cartServices;
        $this->session = $session;
    }
    
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $cart = $this->cartServices->getFullCart();
        
        if (!isset($cart['products'])) {
            return $this->redirectToRoute('home');
        }
        
        if (!$user->getAddresses()->getValues()) { // si l'utilisateur n'a pas mis d'adresse
            
            $this->addFlash('checkout_message', 'Please add an address to your account without continuing !');
            return $this->redirectToRoute('address_new');
        }

        if ($this->session->get('checkout_data')) {
            
            return $this->redirectToRoute('checkout_confirm');
        }
        
        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);
        
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'checkout' => $form->createView()
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/checkout/confirm", name="checkout_confirm")
     *
     * @return Response
     */
    public function confirm(Request $request, OrderServices $orderServices): Response
    {
        $user = $this->getUser();
        $cart = $this->cartServices->getFullCart();

        if (!isset($cart['products'])) {
            return $this->redirectToRoute('home');
        }
        
        if (!$user->getAddresses()->getValues()) { // si l'utilisateur n'a pas mis d'adresse
            
            $this->addFlash('checkout_message', 'Please add an address to your account without continuing !');
            return $this->redirectToRoute('address_new');
        }
        
        $form = $this->createForm(CheckoutType::class, null, ['user' => $user]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data') ) { // si les données viens du formulaire ou bien on a une session(c a dqu'on vient d'une autre page )
            
            if ($this->session->get('checkout_data')) {
                
                $data = $this->session->get('checkout_data');
            }else{
                
                $data = $form->getData();
                $this->session->set('checkout_data', $data); // on garde les données du formulaire dans la session
            }
            
            $address = $data['address'];
            $carrier = $data['carrier'];
            $information = $data['informations'];

            // sauvegarde du pannier 
            $cart['checkout'] = $data;
            $reference = $orderServices->saveCart($cart, $user);
            //dd($reference);
            
            return $this->render("checkout/confirm.html.twig", [
                'cart' => $cart,
                'address' => $address,
                'carrier' => $carrier,
                'information' => $information,
                'reference' => $reference,
                'checkout' => $form->createView()
            ]);
        }

        return $this->redirectToRoute('checkout');
    }

    /**
     * Supprimer la session
     *
     * @Route("/checkout/edit", name="checkout_edit")
     * 
     * @return Response
     */
    public function checkoutEdit(): Response
    {
        $this->session->set('checkout_data', []);
        return $this->redirectToRoute('checkout');
    }
}