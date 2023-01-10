<?php

namespace App\Controller\Admin;

use App\Entity\ShortUrl;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShortUrlCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShortUrl::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new ('created_at')->setDisabled(true);
        yield TextField::new ('original_url');
        yield TextField::new ('short_uri')->addCssClass('optional')->setHelp('Leave empty to obtain random URI.');
    }
}
