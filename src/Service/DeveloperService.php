<?php

namespace App\Service;

use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;

class DeveloperService
{
    public $workload = 0;

    public function __construct(private EntityManagerInterface $entityManager, private TaskService $taskService)
    {
    }

    public function getDevelopers(): array
    {
        return $this->entityManager->getRepository(Developer::class)->findAll();
    }

    public function getDeveloper(int $developer_id): Developer
    {
        return $this->entityManager->getRepository(Developer::class)->find($developer_id);
    }

    public function serializeDeveloper(int $developer_id): object
    {
        $developer = $this->getDeveloper($developer_id);
        return (object)[
            'id' => $developer->getId(),
            'name' => $developer->getName(),
            'difficulty' => $developer->getDifficulty(),
            'workload'  =>  0
        ];
    }

    public function serializeDevelopers(): array
    {
        $developers = $this->getDevelopers();
        $serializedDevelopers = [];
        foreach ($developers as $developer) {
            $serializedDevelopers[] = (object)[
                'id' => $developer->getId(),
                'name' => $developer->getName(),
                'difficulty' => $developer->getDifficulty(),
                'workload'  =>  0
            ];
        }
        return $serializedDevelopers;
    }

    public function assignTasks(): array
    {
        $tasks = $this->taskService->serializeTasks();
        $developers = $this->serializeDevelopers();
        $weeklyTasks = [];
        usort($tasks, function ($a, $b) {
            return $b->difficulty - $a->difficulty;
        });

        $week = 0;
        while (count($tasks) > 0) {
            $week++;
            // echo "Week $week\n";
            foreach ($developers as $developer) {
                $developer->workload = 0;
            }

            foreach ($tasks as $key => $task) {
                usort($developers, function ($a, $b) {
                    return $a->workload - $b->workload;
                });

                foreach ($developers as $developer) {
                    if ($developer->difficulty >= $task->difficulty && $developer->workload + $task->duration <= 45) {
                        $developer->workload += $task->duration;
                        // $developer->tasks[$week][] = $task;
                        // $weeklyTasks[$week][$developer->id]["developer"] = $developer;

                        $weeklyTasks[$week][$developer->id]["workload"] = (isset($weeklyTasks[$week][$developer->id]["workload"]) ? $weeklyTasks[$week][$developer->id]["workload"] : 0) + $task->duration;
                        $weeklyTasks[$week][$developer->id]["tasks"][] = $task;
                        $weeklyTasks[$week][$developer->id]["developer"] = $developer;

                        // echo $developer->name . " assigned " . $task->title . "<br>";
                        unset($tasks[$key]);
                        break;
                    }
                }
            }
        }
        return $weeklyTasks;
        // return $this->serializeWeeklyTasks($weeklyTasks);
    }

    public function serializeWeeklyTasks(array $weeklyTasks): array
    {
        $serializedTasks = [];
        foreach ($weeklyTasks as $key => $weeks) {
            $serializedTasks["weeks"][$key] = [];
            foreach ($weeks as $key => $developer) {
                echo "<pre>";
                print_r($developer);
                echo "</pre>";
                $serializedTasks["weeks"][$key]["developer"] = $this->serializeDeveloper($key);
            }
        }

        return $serializedTasks;
    }
}
