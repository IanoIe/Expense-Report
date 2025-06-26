<?php

namespace App\Controller\Admin;

use App\Entity\PurchaseItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PurchaseItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PurchaseItem::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
