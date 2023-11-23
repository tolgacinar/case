<?php

namespace App\Controller;

use App\Repository\ProviderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(ProviderRepository $providerRepository, private TaskRepository $taskRepository)
    {
    }
    /**
     * @Route("/task", name="app_task")
     */
    public function index(): Response
    {
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
