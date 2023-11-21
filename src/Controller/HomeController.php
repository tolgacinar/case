<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use App\Repository\ProviderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private ProviderRepository $providerRepository, private TaskRepository $taskRepository, private DeveloperRepository $developerRepository)
    {
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        echo "<pre>";
        print_r($this->providerRepository->findAll());
        echo "</pre>";
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
