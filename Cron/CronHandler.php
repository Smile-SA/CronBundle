<?php

namespace Smile\CronBundle\Cron;

class CronHandler extends CronAbstract
{
    /** @var CronInterface[][] $crons crons list */
    private $crons = array();

    /** @var string $cronAlias cron alias */
    protected $cronAlias;

    /** @var integer $cronPriority cron priority */
    protected $cronPriority;

    /** @var array $cronArguments cron arguments */
    protected $cronArguments;

    /**
     * CronHandler constructor.
     * @param string $cronAlias
     * @param integer $cronPriority
     */
    public function __construct($cronAlias = '', $cronPriority = 0, $arguments = array())
    {
        $this->cronAlias = $cronAlias;
        $this->cronPriority = $cronPriority;
        $this->cronArguments = $arguments;
    }

    /**
     * Add cron to crons list
     *
     * @param CronInterface $cron cron
     * @param string $alias cron alias
     * @param integer $priority cron priority
     * @param string $arguments cron arguments
     */
    public function addCron(CronInterface $cron, $alias, $priority, $arguments)
    {
        if (!isset($this->crons[$priority])) {
            $this->crons[$priority] = array();
        }
        $cron->addArguments($arguments);
        $this->crons[$priority][$alias] = $cron;
    }

    /**
     * Sort and return crons list
     *
     * @return array crons list
     */
    public function getCrons()
    {
        ksort($this->crons);
        $crons = array();
        foreach ($this->crons as $priority => $cs) {
            foreach ($cs as $cron) {
                $crons[] = $cron;
            }
        }
        return $crons;
    }
}
