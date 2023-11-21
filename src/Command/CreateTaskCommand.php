<?php

namespace App\Command;

use App\Repository\ProviderRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreateTaskCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:fetch-tasks';

    public function __construct(private ProviderRepository $providerRepository, private HttpClientInterface $client)
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
        $providers = [];
        foreach ($this->providerRepository->findAll() as $provider) {
            $providers[] = [
                'endpoint' => $provider->getUrl(),
                'title' => $provider->getTitle(),
                'params' => $provider->getParams(),
            ];
        }
        $output->writeln([
            json_encode($providers),
            '============',
            '',
        ]);
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command.

        // return this if there was no problem running the command
        return 0;

        // or return this if some error happened during the execution
        // return 1;
    }
}
