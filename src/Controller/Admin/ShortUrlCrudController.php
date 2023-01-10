<?php

namespace App\Controller\Admin;

use App\Entity\ShortUrl;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShortUrlCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShortUrl::class;
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
