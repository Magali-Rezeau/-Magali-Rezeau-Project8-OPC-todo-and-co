<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Controller\AbstractControllerTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends AbstractControllerTest
{
        
    /**
     * Test of the list of all tasks
     */
    public function testListAction()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * Test of the list of tasks to do 
     */
    public function testListActionToDo()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/tasks/todo');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    
    /**
     * Test of the list of completed tasks
     */
    public function testListActionDone()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/tasks/done');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test of the creation of a new task
     */
    public function testCreateAction()
    {
        $this->loginRoleUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = "Le titre de la tâche";
        $form['task[content]'] = "Le contenu de la tâche";
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }
    /**
     * Test update of a task
     */
    public function testEditAction()
    {
        $this->loginRoleUser();
        $crawler = $this->client->request('GET', '/tasks/200/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = "Le titre de la tâche modifié";
        $form['task[content]'] = "Le contenu de la tâche modifié";
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }
    
    /**
     * Test delete a task if the user is not the author
     */
    public function testDeleteActionNotAuthor()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/tasks/200/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test delete a task if the user is an author
     */
    public function testDeleteAction()
    {
        $this->loginRoleUser();
        $this->client->request('GET', '/tasks/194/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * Test delete a task if the user is an admin and the author is anonymous
     */
    public function testDeleteActionAuthorAnonymous()
    {
        $this->loginRoleAdmin();
        $this->client->request('GET', '/tasks/197/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}
