<?php
declare(strict_types=1);

namespace Tests\Integration\Controller;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HistoricalQuotesControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();

    }


    public function testGetSome(){
        $cra = $this->client->request('GET','/api/historical-quotes/aa');

        $this->assertTrue(true);
        $a= $this->client->getResponse()->getContent();
        $b  = $this->client->getResponse()->getContent();

        $this->expectOutputString($b);
    }

    public function testGetSome2(){
        $cra = $this->client->request('GET','/api/historical-quotes/aa');

        $this->assertTrue(true);
        $l = $this->client->getResponse()->getContent();
//        $this->expectOutputString($l);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

}