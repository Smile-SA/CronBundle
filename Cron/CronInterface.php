<?php

namespace Smile\CronBundle\Cron;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface CronInterface
 *
 * @package Smile\CronBundle\Cron
 */
interface CronInterface
{
    /** set Application context */
    public function initApplication(Application $application);

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

    /**
     * Return cron arguments
     *
     * @return string cron arguments
     */
    public function getArguments();

    /**
     * Return cron priority
     *
     * @return int cron priority
     */
    public function getPriority();

    /**
     * Set cron alias
     *
     * @param string $alias cron Alias
     */
    public function setAlias($alias);

    /**
     * Return cron alias
     *
     * @return string cron alias
     */
    public function getAlias();
}
