<?php

namespace Smile\CronBundle\Command;

use Smile\CronBundle\Entity\SmileCron;
use Smile\CronBundle\Service\CronService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronStatusCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('smile:crons:status')
            ->setDescription('Smile cron scheduler status');
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

        $crons = $cronService->listCrons();
        $cronRows = array();

        foreach ($crons as $cron) {
            $cronRows[] = array(
                $cron->getAlias(),
                $cron instanceof SmileCron ? $cron->getQueued()->format('d-m-Y H:i') : false,
                $cron instanceof SmileCron ? $cron->getStarted()->format('d-m-Y H:i') : false,
                $cron instanceof SmileCron ? $cron->getEnded()->format('d-m-Y H:i') : false,
                $cron instanceof SmileCron ? $cron->getStatus() : false
            );
        }

        $table = new Table($output);
        $table
            ->setHeaders(array('Cron Alias', 'Queued', 'Started', 'Ended', 'Status'))
            ->setRows($cronRows)
        ;
        $table->render();
    }
}
