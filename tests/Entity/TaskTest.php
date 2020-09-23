<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Validator\Validation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskTest extends WebTestCase
{
    private $task;

    public function setUp(): void
    {
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->task->getId());
    }

    public function testTitle()
    {
        $this->task->setTitle('title');
        $this->assertSame('title', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('content');
        $this->assertSame('content', $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->task->setIsDone($this->task->IsDone());
        $this->assertEquals(0, $this->task->IsDone());
        $this->task->toggle(true);
        $this->assertSame(true, $this->task->getIsDone());
    }

    public function testCreatedAt()
    {
        $date = new DateTime();
        $this->task->setCreatedAt($date);
        $this->assertSame($date, $this->task->getCreatedAt());
    }

    public function testAuthor()
    {
        $this->task->setAuthor(new User());
        $this->assertInstanceOf(User::class, $this->task->getAuthor());
    }

}
