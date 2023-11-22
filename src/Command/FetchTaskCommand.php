<?php

namespace App\Command;

use App\Entity\Task;
use App\Repository\ProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchTaskCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:fetch-tasks';

    public function __construct(private ValidatorInterface $validatorInterface, private EntityManagerInterface $entityManagerInterface, private ProviderRepository $providerRepository, private HttpClientInterface $client)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Fetch all tasks from providers.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Fetch all tasks from providers...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $providers = $this->getProviders();
        $io = new SymfonyStyle($input, $output);
        $io->title('Fetching tasks from providers');
        $io->table(
            ['Title', 'Endpoint', 'Params'],
            $providers
        );
        $io->section('Tasks');
        $io->newLine(1);
        $io->progressStart();
        $io->newLine(1);
        $tasks = $this->fetchTasks($providers);
        foreach ($tasks as $task) {
            // $io->progressAdvance(count($tasks) % $key);
            $ntask = new Task();
            $ntask->setTitle($task['name']);
            $ntask->setDifficulty($task['difficulty']);
            $ntask->setDuration($task['duration']);

            $this->entityManagerInterface->persist($ntask);
            $this->entityManagerInterface->flush();
            $io->text($ntask->getTitle() . ' added successfully!');
            $io->newLine(1);
        }
        // $io->text(json_encode($tasks));
        $io->progressAdvance(100);
        $io->progressFinish();
        $io->success('All tasks fetched successfully!');
        // $output->writeln([
        //     json_encode($this->fetchTasks($providers)),
        //     '============',
        //     '',
        // ]);
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command.

        // return this if there was no problem running the command
        return 1;

        // or return this if some error happened during the execution
        // return 1;
    }

    protected function fetchTasks(array $providers): array
    {
        $tasks = [];
        foreach ($providers as $provider) {
            $response = $this->client->request('GET', $provider['endpoint']);
            $content = $response->toArray();
            foreach ($content as $task) {
                $tasks[] = [
                    "name" => $task[json_decode($provider['params'], true)['name']],
                    "difficulty" => $task[json_decode($provider['params'], true)['difficulty']],
                    "duration" => $task[json_decode($provider['params'], true)['duration']],
                ];
            }
        }
        return $tasks;
    }

    protected function getProviders(): array
    {
        $providers = [];
        foreach ($this->providerRepository->findAll() as $provider) {
            $providers[] = [
                'endpoint' => $provider->getUrl(),
                'title' => $provider->getTitle(),
                'params' => $provider->getParams(),
            ];
        }
        return $providers;
    }
}
