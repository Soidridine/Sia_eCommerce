<?php

namespace App\Controller\Account;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* Pour uiliser la route account dans toute la class
*
* @Route("/account")
*/
class AccountController extends AbstractController
{
    /**
     * Recupere les commandes payer d'un utilisateur pour l'afficher dans son dashborde
     * 
     * @Route("/", name="account")
     */
    public function index(OrderRepository $orderRepos): Response
    {
        $orders = $orderRepos->findBy(['isPaid' => true, 'user' => $this->getUser()], ['id' => 'DESC']);
       // dd($orders);
        return $this->render('account/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * Affiche le details d'une commande
     * 
     * @Route("/order/{id}", name="account_order_details")
     */
    public function show(?Order $order): Response
    {
        if (!$order || $order->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        if (!$order->getIsPaid()) {
            return $this->redirectToRoute('account');
        }
        return $this->render('account/detail_order.html.twig', [
            'order' => $order
        ]);
    }
}