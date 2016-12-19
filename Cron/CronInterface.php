<?php

namespace Smile\CronBundle\Cron;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface CronInterface
 *
 * @package Smile\CronBundle\Cron
 */
interface CronInterface
{
    /**
     * Execute command
     *
     * @param InputInterface  $input Input interface
     * @param OutputInterface $output Output interface
     */
    public function run(InputInterface $input, OutputInterface $output);

    /**
     * Check cron expression
     *
     * @return bool true if cron should be executed
     */
    public function isDue();

    /**
     * Return the cron expression
     *
     * @return string cron expression
     */
    public function getExpression();

    /**
     * Add cron arguments
     *
     * @param array $arguments cron arguments
     */
    public function addArguments($arguments = '');
}
