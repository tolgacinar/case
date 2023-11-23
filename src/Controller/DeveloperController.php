<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use App\Repository\ProviderRepository;
use Developer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DeveloperController extends AbstractController
{

    private array $providers;
    private array $tasks;

    public function __construct(private HttpClientInterface $client)
    {
    }
    /**
     * @Route("/developer", name="app_developer")
     */
    public function index(DeveloperRepository $developerRepository, ProviderRepository $providerRepository): Response
    {
        return $this->render('developer/index.html.twig', [
            'controller_name' => 'DeveloperController',
        ]);
    }
}
