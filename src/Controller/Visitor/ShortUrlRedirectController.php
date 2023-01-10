<?php

namespace App\Controller\Visitor;

use App\Entity\UrlHit;
use App\Repository\ShortUrlRepository;
use App\Repository\UrlHitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShortUrlRedirectController extends AbstractController
{
    public function __construct(
        private readonly ShortUrlRepository $shortUrlRepository,
        private readonly UrlHitRepository $urlHitRepository,
        private readonly EntityManagerInterface $entityManager
        )
    {

    }

    #[Route('/{slug}', name: 'public')]
    public function index(string $slug): Response
    {
        $matchingShorUrl = $this->shortUrlRepository->findOneBy(['shortUri' => $slug]);
        if (!empty($matchingShorUrl) && !empty($matchingShorUrl->getOriginalUrl())) {
            $urlHit = new UrlHit();
            $urlHit->setShortUrl($matchingShorUrl);
            $this->entityManager->persist($urlHit);
            $this->entityManager->flush();
            return new RedirectResponse($matchingShorUrl->getOriginalUrl(), 302);
        } else {
            return new Response('Not found', 404);
        }
    }
}