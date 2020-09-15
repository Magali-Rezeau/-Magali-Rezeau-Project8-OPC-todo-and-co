<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    
    public function testListAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $link = $crawler->selectButton('Se connecter');
        $form = $link->form();
        $client->submit($form, [
            '_username' => 'tfischer',
            '_password' => 'password'
        ]);
        $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
