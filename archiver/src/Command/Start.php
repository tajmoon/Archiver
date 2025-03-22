<?php

namespace App\Command;

use App\Archiver\Archiver;
use App\Archiver\DataTypes\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;

#[AsCommand(
    name: 'archiver:start',
    description: 'Starts archiver',
    aliases: ['start'],
    hidden: false
)]
final class Start extends Command {
    const FORCE_OPTION = 'force';

    public function __construct(
        private Archiver $archivizer
    ) {
        parent::__construct();
    }

    protected function configure() {
        $this->addOption(
            self::FORCE_OPTION,
            'f',
            InputOption::VALUE_NONE,
            'force mode, don\'t stop on error'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output) : int {
        $this->archivizer->start($input->getOption(self::FORCE_OPTION));
        return Command::SUCCESS;
    }
}