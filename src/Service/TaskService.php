<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getTasks(): array
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }

    public function serializeTasks(): array
    {
        $tasks = $this->getTasks();
        $serializedTasks = [];
        foreach ($tasks as $task) {
            $serializedTasks[] = (object) [
                'id' => $task->getId(),
                'title' => $task->getTitle(),
                'duration' => $task->getDuration(),
                'difficulty' => $task->getDifficulty(),
                'provider' => [
                    'id' => $task->getProvider()->getId(),
                    'title' => $task->getProvider()->getTitle(),
                ],
            ];
        }
        return $serializedTasks;
    }
}
