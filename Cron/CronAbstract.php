<?php

namespace Smile\CronBundle\Cron;

use Cron\CronExpression;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CronAbstract
 *
 * @package Smile\CronBundle\Cron
 */
class CronAbstract extends ContainerAwareCommand implements CronInterface
{
    /** @var string $minute minute expression part */
    protected $minute = '*';

    /** @var string $hour hour minute expression part */
    protected $hour = '*';

    /** @var string $dayOfMonth day of month minute expression part*/
    protected $dayOfMonth = '*';

    /** @var string $month month minute expression part */
    protected $month = '*';

    /** @var string $dayOfWeek day of week minute expression part */
    protected $dayOfWeek = '*';

    /** @var array $arguments cron arguments */
    protected $arguments = array();

    /** @var int $priority cron priority */
    protected $priority = 100;

    /** @var string $alias cron alias */
    protected $alias;

    /**
     * Execute command
     *
     * @param InputInterface  $input Input interface
     * @param OutputInterface $output Output interface
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        return $this->execute($input, $output);
    }

    /**
     * Check cron expression
     *
     * @return bool true if cron should be executed
     */
    public function isDue()
    {
        $expression = $this->getExpression();
        $cron = CronExpression::factory($expression);
        return $cron->isDue();
    }

    /**
     * Return the cron expression
     *
     * @return string cron expression
     */
    public function getExpression()
    {
        $expression = array(
            $this->minute,
            $this->hour,
            $this->dayOfMonth,
            $this->month,
            $this->dayOfWeek
        );

        return implode(' ', $expression);
    }

    /**
     * Add cron arguments
     *
     * @param string $arguments cron arguments
     */
    public function addArguments($arguments = '')
    {
        $args = array();

        preg_match_all('/(?P<argument>\w+):(?P<value>\w+)/', $arguments, $matches);
        if (isset($matches['argument']))
        {
            foreach ($matches['argument'] as $key => $argKey) {
                if (isset($matches['value'][$key])) {
                    $args[$argKey] = $matches['value'][$key];
                }
            }
        }

        $this->arguments = $args;
    }

    public function getArguments()
    {
        $arguments = array();

        foreach ($this->arguments as $key => $val) {
            $arguments[] = '--' . $key . '=' . $val;
        }

        return implode(' ', $arguments);
    }

    public function addPriority($priority)
    {
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get Cron arguments
     *
     * @param InputInterface $input Input interface
     * @param string $key
     * @return mixed return argument from input or tag settings
     */
    public function getArgument(InputInterface $input, $key)
    {
        if ($input->hasArgument($key)) {
            return $input->getArgument($key);
        }

        if (isset($this->arguments[$key])) {
            return $this->arguments[$key];
        }

        return false;
    }

    /**
     * Set cron alias
     *
     * @param string $alias cron alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get cron alias
     *
     * @return string cron alias
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
