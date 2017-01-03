<?php

namespace Smile\CronBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Smile\CronBundle\Cron\CronHandler;
use Smile\CronBundle\Cron\CronInterface;
use Smile\CronBundle\Entity\SmileCron;
use Smile\CronBundle\Repository\SmileCronRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CronService
 * @package Smile\CronBundle\Service
 */
class CronService
{
    /** @var CronHandler $cronHandler */
    protected $cronHandler;

    /** @var SmileCronRepository $repository */
    protected $repository;

    /**
     * CronService constructor.
     *
     * @param CronHandler $cronHandler cron handler
     * @param Registry $doctrineRegistry doctrine registry
     */
    public function __construct(CronHandler $cronHandler, Registry $doctrineRegistry)
    {
        $this->cronHandler = $cronHandler;
        $entityManager = $doctrineRegistry->getManager();
        $this->repository = $entityManager->getRepository('SmileCronBundle:SmileCron');
    }

    /**
     * List cron commands
     *
     * @return CronInterface[] cron command list
     */
    public function getCrons()
    {
        return $this->cronHandler->getCrons();
    }

    /**
     * Identify if cron command is queued
     *
     * @param CronInterface $cron cron command
     * @return bool true if cron command is queued
     */
    public function isQueued(CronInterface $cron)
    {
        return $this->repository->isQueued($cron);
    }

    /**
     * Add cron command to queue
     *
     * @param CronInterface $cron cron command
     */
    public function addQueued(CronInterface $cron)
    {
        $this->repository->addQueued($cron);
    }

    /**
     * List cron commands identified as queued
     *
     * @param InputInterface $input input interface
     * @param OutputInterface $output output interface
     */
    public function runQueued(InputInterface $input, OutputInterface $output)
    {
        /** @var SmileCron[] $smileCrons */
        $smileCrons = $this->repository->listQueued();

        /** @var CronInterface[] $crons */
        $crons = $this->getCrons();
        /** @var CronInterface[] $cronAlias */
        $cronAlias = array();

        foreach ($crons as $cron) {
            $cronAlias[$cron->getAlias()] = $cron;
        }

        if ($smileCrons) {
            foreach ($smileCrons as $smileCron) {
                if (isset($cronAlias[$smileCron->getAlias()])) {
                    $this->repository->run($smileCron);
                    $status = $cronAlias[$smileCron->getAlias()]->run($input, $output);
                    $this->repository->end($smileCron, $status);
                }
            }
        }
    }

    /**
     * Return cron list and status
     *
     * @return SmileCron[] cron list with status
     */
    public function listCronsStatus()
    {
        /** @var SmileCron[] $smileCrons */
        $smileCrons = $this->repository->listCrons();

        /** @var CronInterface[] $crons */
        $crons = $this->getCrons();
        $cronAlias = array();

        foreach ($crons as $cron) {
            $cronAlias[$cron->getAlias()] = $cron;
        }

        if ($smileCrons) {
            foreach ($smileCrons as $smileCron) {
                if (isset($cronAlias[$smileCron->getAlias()])) {
                    $cronAlias[$smileCron->getAlias()] = $smileCron;
                }
            }
        }

        return $cronAlias;
    }
}
