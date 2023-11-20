<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 6; $i++) {
            $developer = new Developer();
            $developer->setName("Developer $i");
            $developer->setDifficulty($i);
            $manager->persist($developer);
        }

        $provider = new Provider();
        $provider->setTitle("Provider 1");
        $provider->setUrl("https://run.mocky.io/v3/27b47d79-f382-4dee-b4fe-a0976ceda9cd");
        $provider->setParams(json_encode([
            "name" => "id",
            "duration" => "sure",
            "difficulty" => "zorluk"
        ]));
        $manager->persist($provider);

        $provider = new Provider();
        $provider->setTitle("Provider 2");
        $provider->setUrl("https://run.mocky.io/v3/7b0ff222-7a9c-4c54-9396-0df58e289143");
        $provider->setParams(json_encode([
            "name" => "id",
            "duration" => "estimated_duration",
            "difficulty" => "value"
        ]));
        $manager->persist($provider);

        $manager->flush();
    }
}
