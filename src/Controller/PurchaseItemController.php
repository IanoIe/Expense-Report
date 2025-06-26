<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PurchaseItemController extends AbstractController
{
    #[Route('/purchase/item', name: 'app_purchase_item')]
    public function index(): Response
    {
        return $this->render('purchase_item/index.html.twig', [
            'controller_name' => 'PurchaseItemController',
        ]);
    }
}
