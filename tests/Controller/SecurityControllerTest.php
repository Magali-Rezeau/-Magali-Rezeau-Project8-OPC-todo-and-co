<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Controller\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * SecurityControllerTest
 */
class SecurityControllerTest extends AbstractControllerTest
{
    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Nom d\'utilisateur")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Mot de passe")')->count());
        $this->assertContains("Se connecter", $crawler->filter('.btn.btn-success')->text());
    }

    public function testLoginError()
    {
        $crawler = $this->client->request('GET', '/login');
        $link = $crawler->selectButton('Se connecter');
        $form = $link->form();
        $this->client->submit($form, [
            '_username' => 'test',
            '_password' => 'test'
        ]);
       
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert-danger');
    }

    public function testLogout()
    {
        $this->loginRoleAdmin();
        $this->client->request('GET', '/logout');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
