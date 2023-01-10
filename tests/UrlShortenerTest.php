<?php
namespace App\Tests;

use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UrlShortenerTest extends WebTestCase
{

    public EntityManagerInterface $entityManager;
    public ShortUrlRepository $shortUrlRepository;
    public $client;

    public function setUp(): void
    {
        $this->entityManager = $this->getContainer()->get('Doctrine\ORM\EntityManagerInterface');
        $this->shortUrlRepository = $this->getContainer()->get('App\Repository\ShortUrlRepository');
    }

    protected function makeClient() {
        //try {
            self::ensureKernelShutdown();
            $this->client = static::createClient();
        //} catch(\Exception $e) {
            // All good
        //}
    }

    public function testRedirectAfterCreateFixedUri()
    {
        $shortUrl = new ShortUrl();
        $shortUrl->setOriginalUrl('http://ab.com');
        $shortUrl->setShortUri('ab');

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();
        $this->assertCount(0, $shortUrl->getUrlHits());

        $this->makeClient();

        for ($a = 0; $a < 3; $a++) {
            $this->client->request('GET', '/ab');
            $this->assertResponseRedirects($shortUrl->getOriginalUrl(), 302);
        }

        $updatedShortUrl = $this->shortUrlRepository->find($shortUrl->getId());

        $this->assertCount(3, $updatedShortUrl->getUrlHits());
    }

    public function testRedirectAfterCreateAutoUri()
    {
        $shortUrl = new ShortUrl();
        $shortUrl->setOriginalUrl('http://hey.com');
        //$shortUrl->setShortUri('ab'); //auto-uri

        $this->entityManager->persist($shortUrl);
        $this->entityManager->flush();
        $this->assertCount(0, $shortUrl->getUrlHits());
        $this->assertNotEmpty($shortUrl->getShortUri());

        $this->makeClient();

        for ($a = 0; $a < 5; $a++) {
            $this->client->request('GET', $shortUrl->getShortUri());
            $this->assertResponseRedirects($shortUrl->getOriginalUrl(), 302);
        }

        $updatedShortUrl = $this->shortUrlRepository->find($shortUrl->getId());

        $this->assertCount(5, $updatedShortUrl->getUrlHits());
    }

    public function testRedirectTo404ForUnknownSlug()
    {
        $this->makeClient();
        $this->client->request('GET', '/nonSenseUrl');
        $this->assertResponseStatusCodeSame(404);
    }
}