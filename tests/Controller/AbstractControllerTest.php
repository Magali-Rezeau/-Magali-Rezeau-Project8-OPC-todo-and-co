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
            'username' => 'dupuy.denise',
            'password' => 'password'
        ]);

        $this->client->submit($form);
    }

    public function loginRoleUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'username' => 'tfischer',
            'password' => 'password'
        ]);

        $this->client->submit($form);
    }

    public function loginRoleAnonymous(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'username' => 'gpoirier',
            'password' => 'password'
        ]);

        $this->client->submit($form);
    }
}
