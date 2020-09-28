<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Controller\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends AbstractControllerTest
{     
    /**
     * Test of the list of all users if the user has the admin role 
     */
    public function testListActionRoleAdmin()
    {
        $this->loginRoleAdmin();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test of the list of all users if the user has the user role 
     */
    public function testListActionRoleUser()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/users');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test of the creation of a new user
     */
    public function testCreateAction()
    {
        $this->loginRoleAdmin();
        $crawler = $this->client->request('GET', '/users/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = "username";
        $form['user[password][first]'] = "password";
        $form['user[password][second]'] = "password";
        $form['user[email]'] = "test@email.com";
        $form['user[roles]']->select("ROLE_USER");
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(1, $crawler->filter('html:contains("L\'utilisateur a bien été ajouté.")')->count());
    }

    /**
     * Test update of a user
     */
    public function testEditAction()
    {
        $this->loginRoleAdmin();
        $crawler = $this->client->request('GET', '/users/2/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = "username";
        $form['user[password][first]'] = "password";
        $form['user[password][second]'] = "password";
        $form['user[email]'] = "test@email.com";
        $form['user[roles]']->select("ROLE_ADMIN");
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        $this->assertSame(1, $crawler->filter('html:contains("L\'utilisateur a bien été modifié.")')->count());
    }

}
        