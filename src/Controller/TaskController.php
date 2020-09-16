<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }
    
    /**
     * Consult the list of all tasks
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findAll();
        return $this->render('task/list.html.twig', ['tasks' => $tasks]);
    }

    /**
     * Consult the list of all tasks to do 
     * @Route("/tasks/todo", name="task_list_todo")
     */
    public function listActionToDo(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findBy(['isDone' => false]);
        return $this->render('task/list-todo.html.twig', ['tasks' => $tasks]);
    }

    /**
     * Consult the list of completed tasks
     * @Route("/tasks/done", name="task_list_done")
     */
    public function listActionDone(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->findBy(['isDone' => true]);
        return $this->render('task/list-done.html.twig', ['tasks' => $tasks]);
    }

    /**
     * Creation of a new task
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, Security $security)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setAuthor($security->getUser());
            $this->manager->persist($task);
            $this->manager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Update a task
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($task);
            $this->manager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * 
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->manager->persist($task);
        $this->manager->flush();

        if($task->isDone() === true) {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
            return $this->redirectToRoute('task_list_done');
        } else {
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non terminée.', $task->getTitle()));
            return $this->redirectToRoute('task_list_todo');
        }
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('DELETE', $task);

        $this->manager->remove($task);
        $this->manager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
