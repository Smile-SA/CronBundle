<?php

namespace Smile\CronBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SmileCron
 *
 * @ORM\Entity(repositoryClass="Smile\CronBundle\Repository\SmileCronRepository")
 * @ORM\Table(name="smile_cron")
 */
class SmileCron
{
    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=false)
     * @ORM\Id
     */
    private $alias;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="queued", type="datetime", nullable=false)
     */
    private $queued = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started", type="datetime", nullable=true)
     */
    private $started;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended", type="datetime", nullable=true)
     */
    private $ended;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';



    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return SmileCron
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Set queued
     *
     * @param \DateTime $queued
     *
     * @return SmileCron
     */
    public function setQueued($queued)
    {
        $this->queued = $queued;

        return $this;
    }

    /**
     * Get queued
     *
     * @return \DateTime
     */
    public function getQueued()
    {
        return $this->queued;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     *
     * @return SmileCron
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set ended
     *
     * @param \DateTime $ended
     *
     * @return SmileCron
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return \DateTime
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return SmileCron
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
