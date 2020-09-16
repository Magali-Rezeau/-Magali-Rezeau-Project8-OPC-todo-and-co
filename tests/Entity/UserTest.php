<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private $user;

    public function setUp():void
    {
        $this->user = new User();
    }

    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername('username');
        $this->assertSame('username', $this->user->getUsername());
    }

    public function testPassword()
    {
        $this->user->setPassword('password');
        $this->assertSame('password', $this->user->getPassword());
    }

    public function testEmail(): void
    {
        $this->user->setEmail('email@test.fr');
        $this->assertSame('email@test.fr', $this->user->getEmail());
    }

    public function testTasks()
    {
        $task = new Task();
        $this->user->addTask($task);
        $collection = $this->user->getTasks();
        $this->assertEquals(false, $collection->isEmpty());

        $this->user->removeTask($task);
        $this->assertEquals(true, $collection->isEmpty());
    }

    public function testNoTasks()
    {
        $collection = $this->user->getTasks();
        $this->assertEquals(true, $collection->isEmpty());
    }

    public function testRolesUser(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testNoRoles()
    {
        $this->user->setRoles(['ROLE_ANONYMOUS']);
        $this->assertSame(['ROLE_ANONYMOUS'], $this->user->getRoles());
    }

    public function testRolesAdmin()
    {
        $this->user->setRoles(['ROLE_ADMIN']);
        $this->assertSame(['ROLE_ADMIN'], $this->user->getRoles());
    }

    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

}