<?php

namespace App\Controller;

use App\Entity\Urgence;
use App\Form\UrgenceType;
use App\Repository\HopitalRepository;
use App\Repository\UrgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/urgence')]
class UrgenceController extends AbstractController
{

    #[Route('/new/{id_hopital}', name: 'app_urgence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,int $id_hopital,HopitalRepository $hopitalRepository): Response
    {
        $urgence = new Urgence();
        $form = $this->createForm(UrgenceType::class, $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hopital = $hopitalRepository->find($id_hopital);
            $urgence->setHopital($hopital);
            $urgence->setNombreLitDisponible($urgence->getNombreLit());
            $entityManager->persist($urgence);
            $entityManager->flush();

            return $this->redirectToRoute('app_hopital_show', ['id'=> $id_hopital], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('urgence/new.html.twig', [
            'urgence' => $urgence,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_urgence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Urgence $urgence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UrgenceType::class, $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hopital_show', ['id'=> $urgence->getHopital()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('urgence/edit.html.twig', [
            'urgence' => $urgence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_urgence_delete', methods: ['POST'])]
    public function delete(Request $request, Urgence $urgence, EntityManagerInterface $entityManager): Response
    {
        $id_Hopital = $urgence->getHopital()->getId();
        if ($this->isCsrfTokenValid('delete'.$urgence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($urgence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hopital_show', ['id'=> $id_Hopital], Response::HTTP_SEE_OTHER);
    }
}
