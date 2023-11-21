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
        $developerArray = [];
        $developers = $developerRepository->findAll();
        foreach ($developers as $developer) {
            $name = $developer->getName();
            $difficulty = $developer->getDifficulty();
            $developerArray[] = [
                'name' => $name,
                'difficulty' => $difficulty,
            ];
        }
        foreach ($providerRepository->findAll() as $provider) {
            $endpoint = $provider->getUrl();
            $title = $provider->getTitle();
            $params = $provider->getParams();
            $params = json_decode($params, true);

            $response = $this->client->request('GET', $endpoint);

            if ($content = $response->getContent()) {
                $content = json_decode($content, true);
                foreach ($content as $task) {
                    $this->tasks[] = [
                        'difficulty' => $task[$params['difficulty']],
                        'duration' => $task[$params['duration']],
                        'name' => $task[$params['name']]
                    ];
                }
            }
        }



        echo "<pre>";
        print_r($this->tasks);
        echo "</pre>";
        return $this->render('developer/index.html.twig', [
            'controller_name' => 'DeveloperController',
        ]);
    }
}
