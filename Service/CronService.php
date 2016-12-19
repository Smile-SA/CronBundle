<?php

namespace Smile\CronBundle\Service;

use Smile\CronBundle\Cron\CronHandler;

class CronService
{
    /** @var CronHandler $cronHandler */
    protected $cronHandler;

    public function __construct(CronHandler $cronHandler)
    {
        $this->cronHandler = $cronHandler;
    }

    public function getCrons()
    {
        return $this->cronHandler->getCrons();
    }
}
