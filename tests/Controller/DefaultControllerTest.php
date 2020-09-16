<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Tests\Controller\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends AbstractControllerTest
{
    public function testIndexAction()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginRoleUser();
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Créer une nouvelle tâche", $crawler->filter('a.btn.btn-success')->text());
        $this->assertContains("Consulter la liste de toutes les tâches", $crawler->filter('a.btn.btn-info')->text());
        $this->assertContains("Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !", $crawler->filter('h1')->text());
        $this->assertSame(1, $crawler->filter('html:contains("Se déconnecter")')->count());
    }

    public function testIndexActionNotLogged()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());  
    }
}
