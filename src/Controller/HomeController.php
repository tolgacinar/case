<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Repository\DeveloperRepository;
use App\Repository\ProviderRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    public function __construct(private HttpClientInterface $client, private ProviderRepository $pr)
    {
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProviderRepository $pr): Response
    {

        foreach ($this->pr->findAll() as $p) {
            $response = $this->client->request('GET', $p->getUrl());
            $content = $response->toArray();
            foreach ($content as $task) {
                $tasks[] = [
                    "name" => $task[$p->getParams("name")]
                ];
            }
        }
        echo "<pre>";
        print_r($tasks);
        echo "</pre>";

        die();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
