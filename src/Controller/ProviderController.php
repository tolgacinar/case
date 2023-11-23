<?php

namespace App\Controller;

use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Provider;

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
    /**
     * @Route("/provider/create", methods={"POST"}, name="app_provider_create")
     */
    public function createProvider(Request $request, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(), true);
        $provider = new Provider();
        $params = isset($data['params']) ? $data['params'] : null;
        $title = isset($data['title']) ? $data['title'] : null;
        $url = isset($data['url']) ? $data['url'] : null;
        if (!$data) {
            return new JsonResponse(['errors' => 'You\'ve entered an invalid Data.'], JsonResponse::HTTP_BAD_REQUEST);
        }
        if (!$params || !is_array($params)) {
            return new JsonResponse(['errors' => 'You\'ve entered an invalid Data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        foreach (["name", "difficulty", "duration"] as $key) {
            if (!in_array($key, array_keys($params))) {
                return new JsonResponse(['errors' => 'Incorrect array fields.'], JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        $provider->setTitle($title);
        $provider->setUrl($url);
        $provider->setParams(json_encode($params));

        $errors = $validator->validate($provider);

        if (count($errors) > 0) {
            // Doğrulama hatası varsa
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($provider);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Veri başarıyla kaydedildi'], JsonResponse::HTTP_CREATED);
    }
}
