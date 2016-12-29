<?php

namespace Smile\CronBundle\Command;

use Smile\CronBundle\Cron\CronInterface;
use Smile\CronBundle\Service\CronService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CronCommand
 *
 * @package Smile\CronBundle\Command
 */
class CronCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('smile:crons:run')
            ->setDescription('Smile cron scheduler');
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input Input interface
     * @param OutputInterface $output Output interface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CronService $cronService */
        $cronService = $this->getContainer()->get('smile.cron.service');
        /** @var CronInterface[] $cronsDue */
        $cronsDue = array();

        /** @var CronInterface[] $crons */
        $crons = $cronService->getCrons();
        foreach ($crons as $cron) {
            if ($cron->isDue()) {
                $cronsDue[] = $cron;
            }
        }

        foreach ($cronsDue as $cron) {
            if (!$cronService->isQueued($cron)) {
                $cronService->addQueued($cron);
            }
        }

        $cronService->runQueued($input, $output);
    }
}
