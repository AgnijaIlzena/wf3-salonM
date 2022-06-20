<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout($stripeSK): Response
    {
       Stripe::setApiKey($stripeSK);

       $session = Session::create([
        'line_items' => [[
          'price_data' => [
            'currency' => 'eur',
            'product_data' => [
              'name' => 'Massage',
            ],
            'unit_amount' => 9000,
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
      ]);

      //return $response->withHeader('Location', $session->url)->withStatus(303);
      return $this->redirect($session->url, 303);
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', [     
        ]);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', [     
        ]);
    }
}
