<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Entity\Reservation;
use App\Entity\Massage;
use App\Repository\ReservationRepository;
use App\Repository\GiftRepository;
use App\Repository\MassageRepository;
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

    #[Route('/checkout/{id}', name: 'app_checkout', requirements: ['id' => '\d+'])]
    public function checkout(Reservation $reservation, $stripeSK ): Response
    {

      // dd($reservation->getMassagist()->getName());
       Stripe::setApiKey($stripeSK);
       
       $serviceDetails = $reservation->getMassage()->getName() .' le '. $reservation->getDate() .' à '. $reservation->getTimeSlot();
       $description = $reservation->getMassage()->getDescription() .'. Votre masseur est : '. $reservation->getMassagist()->getName(); 

       $session = Session::create([
        'line_items' => [[
          'price_data' => [
            'currency' => 'eur',
            'product_data' => [
              'name' => $serviceDetails,
              'description' => $description,
                ],
            'unit_amount' => $reservation->getMassage()->getPrice() * 100,
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'metadata' => [
          'reservation_id' => $reservation->getId(),
      ]
      ]);

      return $this->redirect($session->url, 303, [
        
        'reservation'=>$reservation,
      ]);
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


// add gift variable in route and further
// connect with gift controller as it was with reservations (redirect to route)
    #[Route('/checkout/{id}/{cadeau}', name: 'app_checkout_gift', requirements: ['id' => '\d+'])]
    public function checkoutGift(Gift $gift, $stripeSK ): Response
    {

      // dd($reservation->getMassagist()->getName());
       Stripe::setApiKey($stripeSK);      
         
       $session = Session::create([
        'line_items' => [[
          'price_data' => [
            'currency' => 'eur',
            'product_data' => [
              'name' => $gift->getMassage()->getName(),
              'description' => $gift->getMassage()->getDescription(),
                ],
            'unit_amount' => $gift->getMassage()->getPrice() * 100,
          ],
          'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        'metadata' => [
          'gift_id' => $gift->getId(),
      ]
      ]);

      return $this->redirect($session->url, 303, [
        
        'gift' => $gift,
        'cadeau' => 'cadeau',
      ]);
    }


}
