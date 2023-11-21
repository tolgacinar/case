<?php

namespace App\Controller;

use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    public function __construct(ProviderRepository $providerRepository)
    {
    }
    /**
     * @Route("/provider", name="app_provider")
     */
    public function index(): Response
    {
        return $this->render('provider/index.html.twig', [
            'controller_name' => 'ProviderController',
        ]);
    }
}
