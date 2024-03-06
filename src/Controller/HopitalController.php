<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Entity\HopitalImage;
use App\Form\HopitalType;
use App\Repository\EvenementRepository;
use App\Repository\HopitalRepository;
use App\Repository\ImagesRepository;
use App\Repository\ReservationRepository;
use App\Repository\UrgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hopital')]
class HopitalController extends AbstractController
{
    #[Route('/', name: 'app_hopital_index', methods: ['GET'])]
    public function index(HopitalRepository $hopitalRepository,UrgenceRepository $urgenceRepository): Response
    {
        return $this->render('hopital/index.html.twig', [
            'hopitals' => $hopitalRepository->findAll(),
            'urgences' => $urgenceRepository->findAll()
        ]);
    }

    #[Route('/User', name: 'app_hopital_index_user', methods: ['GET'])]
    public function indexUser(HopitalRepository $hopitalRepository,UrgenceRepository $urgenceRepository): Response
    {
        return $this->render('hopital/indexUser.html.twig', [
            'hopitals' => $hopitalRepository->findAll(),
            'urgences' => $urgenceRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_hopital_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, KernelInterface $kernel): Response
    {
        $hopital = new Hopital();
        $form = $this->createForm(HopitalType::class, $hopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $images = $request->files->get('hopital')['images'];
            foreach ($images as $image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $kernel->getProjectDir().'/public/uploads',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }

                // Save file path in the entity
                $hopitalImage = new HopitalImage();
                $hopitalImage->setImageUrl('uploads/'.$newFilename);
                $hopitalImage->setHopital($hopital);
                $entityManager->persist($hopitalImage);
            }

            $entityManager->persist($hopital);
            $entityManager->flush();

            return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hopital/new.html.twig', [
            'hopital' => $hopital,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_hopital_show', methods: ['GET'])]
    public function show(Hopital $hopital,UrgenceRepository $urgenceRepository,ReservationRepository $reservationRepository): Response
    {
        $urgence = $urgenceRepository->findByHopital($hopital->getId());
        $todayReservationCount = $reservationRepository->countReservationsForTodayByUrgence($urgence->getId());
        $total = $urgence->getNombreLitDisponible() - $todayReservationCount ;
        return $this->render('hopital/show.html.twig', [
            'hopital' => $hopital,
            'urgence' => $urgence,
            'total' => $total
        ]);
    }

    #[Route('/User/{id}', name: 'app_hopital_show_user', methods: ['GET'])]
    public function showUser(Hopital $hopital,UrgenceRepository $urgenceRepository,ReservationRepository $reservationRepository): Response
    {
        $urgence = $urgenceRepository->findByHopital($hopital->getId());
        $todayReservationCount = $reservationRepository->countReservationsForTodayByUrgence($urgence->getId());
        $total = $urgence->getNombreLitDisponible() - $todayReservationCount ;
        return $this->render('hopital/showUser.html.twig', [
            'hopital' => $hopital,
            'urgence' => $urgence,
            'total' => $total
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hopital_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hopital $hopital, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HopitalType::class, $hopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hopital/edit.html.twig', [
            'hopital' => $hopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hopital_delete', methods: ['POST'])]
    public function delete(Request $request, Hopital $hopital, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hopital->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hopital);
            $entityManager->flush();
            return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER) ;


        }

        return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/search/ajax', name: 'app_ajax_hopital', methods: ['GET'])]
    public function ajaxHopital(Request $request,HopitalRepository $hopitalRepository,UrgenceRepository $urgenceRepository): Response
    {
        $requestString=$request->get('searchValue');
        return $this->render('hopital/ajax.html.twig', [
            'hopitals' => $hopitalRepository->findByNom($requestString),
            'urgences' => $urgenceRepository->findAll()
        ]);
    }

    #[Route('/search/User/ajax', name: 'app_ajax_hopital_user', methods: ['GET'])]
    public function ajaxHopitalUser(Request $request,HopitalRepository $hopitalRepository,UrgenceRepository $urgenceRepository): Response
    {
        $requestString=$request->get('searchValue');
        return $this->render('hopital/ajaxUser.html.twig', [
            'hopitals' => $hopitalRepository->findByNom($requestString),
            'urgences' => $urgenceRepository->findAll()
        ]);
    }
}
