<?php

namespace App\Controller\Admin;

use App\Entity\HomeSlider;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HomeSliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HomeSlider::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('description'),
            TextField::new('buttonMessage'),
            TextField::new('buttonURL', 'Url'),
            ImageField::new('image')->setUploadDir("public/assets/uploads/sliders")->setBasePath("/assets/uploads/sliders")
                                   ->setUploadedFileNamePattern('[randomhash].[extention]')->setRequired(false),
            BooleanField::new('isDisplayed', 'Display'),
        ];
    }
    
}