<?php

namespace App\Service;

use App\Repository\CommandRepository;
use App\Repository\ProspectRepository;

class Gulliver
{
    /**
     * @var CommandRepository $commandRepository
     */
    private $commandRepository;

    private $prospectRepository;

    public function __construct(CommandRepository $commandRepository, ProspectRepository $prospectRepository)
    {
        $this->commandRepository = $commandRepository;
        $this->prospectRepository = $prospectRepository;
    }


    public function travel($filters)
    {
        $commands = $this->commandRepository->findBySupport($filters);
        $prospects = [];
        $prospects['count_commands'] = \count($commands);
        foreach ($commands as $command) {
            $prospects[] = $this->prospectRepository->findOneBy(['id' => $command->getId()]);
        }
        return $prospects;
    }
}