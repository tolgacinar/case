<?php

namespace App\Controller;

use App\Service\DeveloperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $developerService;
    public function __construct(DeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $weeklyTasks = $this->developerService->assignTasks();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'weeklyTasks' => $weeklyTasks
        ]);
    }
}
