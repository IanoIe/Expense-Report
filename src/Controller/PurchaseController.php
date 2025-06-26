<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Form\PurchaseTypeForm;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


final class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'app_purchase')]
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        $purchases = $purchaseRepository->findAll();

        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
            'purchases' => $purchases,
        ]);
    }

    #[Route('/purchase/{id}', name: 'app_purchase_show', methods: ['GET'])]
    public function show(Purchase $purchase): Response
    {
        return $this->render('purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }


   #[Route('/purchase/{id}/edit', name: 'app_purchase_edit', methods: ['GET', 'POST'])]
   public function edit(Request $request, Purchase $purchase, EntityManagerInterface $em): Response
   {
       $form = $this->createForm(PurchaseTypeForm::class, $purchase);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Purchase updated successfully.');
            return $this->redirectToRoute('app_purchase');
        }

        return $this->render('purchase/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/purchase/{id}/delete', name: 'app_purchase_delete', methods: ['POST'])]
    public function delete(Request $request, Purchase $purchase, EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager): RedirectResponse
    {
        $submittedToken = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$purchase->getId(), $submittedToken)))
        {
            $em->remove($purchase);
            $em->flush();

            $this->addFlash('success', 'Purchase deleted successfully.');
        } else {
                 $this->addFlash('error', 'Invalid CSRF token.');
               }
         return $this->redirectToRoute('app_purchase');
    }
}
