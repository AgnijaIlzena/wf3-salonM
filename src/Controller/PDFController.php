<?php

namespace App\Controller;

use App\Repository\MassageRepository;
use App\Repository\GiftRepository;
use App\Entity\user;
use App\Entity\Gift;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PDFController extends AbstractController
{
    protected $parameterBag;

public function __construct(ParameterBagInterface $parameterBag)
{
    $this->parameterBag = $parameterBag;

}

    #[Route('/pdf', name: 'app_pdf')]
    public function index(UserRepository $userRepository, MassageRepository $massageRepository, MailerInterface $mailer )
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/index.html.twig', [
            'user' => $userRepository->find(1),
            'massages' => $massageRepository->findAll()
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->parameterBag->get('kernel.project_dir') . '/public';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/mypdf.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        
        $email = (new Email())
        ->from('wf3-salonm@gmail.com')
        ->to('seether.anas2911@gmail.com')
        ->subject('Facture')
        ->text('Thank you for using our services , we are waiting your next visit')
        ->attachFromPath($pdfFilepath);

        $mailer->send($email);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }

    #[Route('/giftpdf', name: 'app_giftpdf')]
    public function gift(UserRepository $userRepository, MassageRepository $massageRepository, GiftRepository $giftRepository , MailerInterface $mailer )
    {
        $giftOptions = new Options();
        $giftOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($giftOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/giftPdf.html.twig', [
            'user' => $userRepository->find(1),
            'massages' => $massageRepository->findAll(),
            'gift' => $giftRepository->find(1)
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();


        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->parameterBag->get('kernel.project_dir') . '/public';
        // e.g /var/www/project/public/mypdf.pdf
        $giftFilepath =  $publicDirectory . '/giftPdf.pdf';

        // Write file to the desired path
        file_put_contents($giftFilepath, $output);

}
}