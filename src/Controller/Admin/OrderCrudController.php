<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('user.FullName', 'Client'),
            TextField::new('carrierName', 'Carrier name'),
            MoneyField::new('carrierPrice', 'Shipping')->setCurrency('USD'),
            MoneyField::new('subTotalHT', 'Subtotal HT')->setCurrency('USD'),
            MoneyField::new('taxe', 'TVA')->setCurrency('USD'),
            MoneyField::new('subTotalTTC', 'Subtotal TTC')->setCurrency('USD'),
            BooleanField::new('isPaid'),
        ];
    }
    
}