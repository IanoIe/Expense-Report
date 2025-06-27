<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function index(): Response
    {
        $conn = $this->em->getConnection();

        $sql = <<<SQL
            SELECT
                p.store_name,
                pi.product_name,
                p.date,
                pi.total_price
            FROM purchase_item pi
            JOIN purchase p ON p.id = pi.purchase_id
            ORDER BY p.date DESC
        SQL;

        $purchaseDetails = $conn->executeQuery($sql)->fetchAllAssociative();

        return $this->render('admin/dashboard.html.twig', [
            'purchaseDetails' => $purchaseDetails,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Expense Report');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Purchase', 'fas fa-shopping-cart', Purchase::class);
        yield MenuItem::linkToCrud('Purchase Item', 'fas fa-box', PurchaseItem::class);

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('User', 'fas fa-user-shield', User::class);
        }
    }
}
