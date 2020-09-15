<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{

    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginRoleAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'dupuy.denise',
            '_password' => 'password'
        ]);

        $this->client->submit($form);
    }

    public function loginRoleUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'tfischer',
            '_password' => 'password'
        ]);

        $this->client->submit($form);
    }

    public function loginRoleAnonymous(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'gpoirier',
            '_password' => 'password'
        ]);

        $this->client->submit($form);
    }
}
