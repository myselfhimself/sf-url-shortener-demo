<?php

namespace App\Controller\Visitor;

use App\Entity\ShortUrl;
use App\Form\Type\ShortUrlType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ShortUrlAdderController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    #[Route('/', name: 'home')]
    public function home(Request $request)
    {
        $shortUrl = new ShortUrl();

        $form = $this->createForm(ShortUrlType::class, $shortUrl);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shortUrl = $form->getData();

            $this->entityManager->persist($shortUrl);
            $this->entityManager->flush();

            return $this->redirectToRoute(
                'shorturl_success',
                [
                    'shortUri' => $shortUrl->getShortUri(),
                    'origUrl' => $shortUrl->getOriginalUrl()
                ]
            );
        }

        return $this->render('visitor/shortUrl/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/success', name: 'shorturl_success')]
    public function success(Request $request)
    {
        return $this->render(
            'visitor/shortUrl/success.html.twig',
            [
                'origUrl' => $request->query->get('origUrl'),
                'shortUri' => $request->query->get('shortUri')
            ]
        );
    }
}