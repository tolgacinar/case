<?php

namespace App\Service;

use App\Entity\Provider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Webmozart\Assert\Assert as AssertAssert;

class ProviderService
{
    public $workload = 0;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('title', new Assert\NotBlank());
        $metadata->addPropertyConstraint('url', new Assert\NotBlank());
        $metadata->addPropertyConstraint('params', new Assert\Json([
            'message' => 'You\'ve entered an invalid Json.',
        ]));
    }

    public function createProvider(string $title, string $url, string $params): Provider
    {
        $provider = new Provider();
        $provider->setTitle($title);
        $provider->setUrl($url);
        $provider->setParams(json_encode($params));
        $errors = $this->validator->validate($provider);
        if (count($errors) > 0) {
            throw new \Exception((string) $errors);
        }
        $this->entityManager->persist($provider);
        $this->entityManager->flush();
        return $provider;
    }
}
