<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\UrgenceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new/{id_urgence}', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
                        SluggerInterface $slugger,
                        MailerInterface $mailer,int $id_urgence,UrgenceRepository $urgenceRepository,UserRepository $userRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUserReservation($userRepository->find(1));
            $currentDateTime = new \DateTime();
            $reservation->setDate($currentDateTime);
            $reservation->setUrgence($urgenceRepository->find($id_urgence));
            $entityManager->persist($reservation);
            $entityManager->flush();
            // Render HTML page template
            $html = $this->renderView('reservation/mail.html.twig', [
                'reservation' => $reservation,
            ]);

            // Save the HTML page
            $htmlFileName = $slugger->slug($reservation->getId() . '_participation.html');
            $htmlFilePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $htmlFileName;
            file_put_contents($htmlFilePath, $html);

            // Use the builder to create the QR code
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($this->generateUrl('app_reservation_show_qr', ['id' => $reservation->getId()], UrlGeneratorInterface::ABSOLUTE_URL))
                ->encoding(new Encoding('UTF-8'))  // Optional, adjust encoding if needed
                ->size(300)  // Optional, adjust size
                ->margin(10)
                ->build();


            // Generate the file path
            $fileName = $reservation->getId() . '-qr-code.png';
            $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $fileName;
            $result->saveToFile($filePath);

            $part = new DataPart(fopen($filePath, 'r'));
            $part->hasContentId('qr-code');

            $email = (new Email())
                ->from('ghouthiamine@gmail.com')
                ->to('medyassine.ghouthi@esprit.tn')
                ->subject('Your QR Ticket');

            $imageData = fopen($filePath, 'r');
            $email->embed($imageData, 'qr-code.png'); // Embed the image data, provide a name for the image

            $htmlContent = '<p>Reservation a été fait avec success :</p><img src="cid:qr-code.png">';
            $email->html($htmlContent);

            $mailer->send($email);

            return $this->redirectToRoute('app_hopital_index_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/qr/{id}', name: 'app_reservation_show_qr', methods: ['GET'])]
    public function showQrTicket(Reservation $reservation): Response
    {
        return $this->render('reservation/mail.html.twig', [
            'reservation' => $reservation,
        ]);
    }

}
