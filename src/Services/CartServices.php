<?php 

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{
    
    /**
     * 
     */
    private $session;
    
    private $repoProduct;

    private $taxe = 0.2;
    
    public function __construct(SessionInterface $session, ProductRepository $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }
    
    /**
     * Ajout d'un produit dans le panier
     *
     * @param [type] $id
     * @return void
     */
    public function addToCart($id)
    {
        $cart = $this->getCart(); // on recuperer une instance du panier 
        
        if (isset($cart[$id])) 
        {
            // Si ce produit existe dans le panier alors on incremente sa quantitée
            $cart[$id]++;
            
        }else {
            // Ce produit n'existe pas dans le panier donc on l'affecte a 1
            $cart[$id] = 1;
        }

        $this->updateCart($cart); // on met ajour le panier
    }

    /**
     * Supprime un produit dans le panier
     *
     * @param [type] $id
     * 
     */
    public function deleteFromCart($id)
    {
        $cart = $this->getCart();
        
        if (isset($cart[$id])) // est ce que le produit qui a l'id $d existe dans le panier
        {
            if ($cart[$id] > 1) // dans le cas ou le produit existe plus d'une fois
            {
                $cart[$id]--;
            }else{
                unset($cart[$id]); // on le retire du pannier
            }
            
            $this->updateCart($cart); // on met à jour le pannier
        }
    }

    /**
     * Supprime le produit dans le panier avec la quantité(c a d: Si on a un produit avec la quantité 3 il supprime tous)
     * 
     */
    public function deleteAllToCart($id)
    {
        $cart = $this->getCart();
        
        if (isset($cart[$id])) 
        {
            // Produit existe deja dans le pannier on le supprime
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }

    /**
     * Supprime le panier
     */
    public function deleteCart()
    {
        $this->updateCart([]); // on vide le pannier
    }

    /**
     * Mettre ajour le panier et il prend en parametre le panier $cart
     * @param [type] $cart
     */
    public function updateCart($cart)
    {
        $this->session->set('cart', $cart);
        $this->session->set('cartData', $this->getFullCart()); // recupere les informations du pannier et met dans la session (produit, quantite ....)
    }
    
    public function getCart()
    {
        return $this->session->get('cart', []); // on recupere le panier avec la clé 'cart' et on met un tableau vide au cas ou on a pas le panier est vide
    }

    /**
     * Il ecupere le pannier completr
     *
     * @return void
     */
    public function getFullCart()
    {
        $cart = $this->getCart();

        $fullCart = []; // tableau vide qui va recevoir le produit et sa quantité 
        $quantity_cart = 0; // quantité total du pannier
        $subTotal = 0; // Le prix total du pannier
        
        foreach ($cart as $id => $quantity) 
        {
            $product = $this->repoProduct->find($id);
            
            if ($product) {
                //  produit recuperer
                $fullCart['products'][] = [   // on a une clé products qui contiendra les produit qui sont dans le pannier
                    "quantity" => $quantity, 
                    "product" => $product
                ];
                
                $quantity_cart += $quantity; // une fois qu'on a un nouveau produit on incremente la quantitité du pannier
                $subTotal += $quantity * $product->getPrice()/100;
            }else{
                // l'id incorrecte
                $this->deleteFromCart($id);
            }
        }

        $fullCart['data'] = [ // Data il contiendra les informations qui sont dans le pannier comme quantité total .....
            "quantity_cart" => $quantity_cart,
            "subTotalHT" => $subTotal,
            "taxe" => round($subTotal * $this->taxe, 2),
            "subtotalTTC" => round(($subTotal + ($subTotal * $this->taxe)), 2)
        ];

        return $fullCart;
    }
}