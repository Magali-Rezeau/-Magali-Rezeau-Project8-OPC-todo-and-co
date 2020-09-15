<?php 

namespace App\Tests\Form;

use DateTime;
use App\Entity\Task;
use App\Form\TaskType;
use App\Model\TestObject;
use App\Form\Type\TestedType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'title',
            'content' => 'content',
        ];

        $model = new Task();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $model);

        $task = new Task();
        // ...populate $object properties with the data stored in $formData
        $task->setTitle($formData['title']);
        $task->setContent($formData['content']);
        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($task->getTitle(), $form->getData()->getTitle());
        $this->assertEquals($task->getContent(), $form->getData()->getContent());
    }
}
