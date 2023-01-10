<?php

namespace App\Controller\Admin;

use App\Entity\UrlHit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class UrlHitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UrlHit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new ('created_at');
        yield AssociationField::new ('shortUrl')
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->autocomplete();
    }

}