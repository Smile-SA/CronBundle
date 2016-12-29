<?php

namespace Smile\CronBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Smile\CronBundle\Cron\CronInterface;
use Smile\CronBundle\Entity\SmileCron;

/**
 * Class SmileCronRepository
 * @package Smile\CronBundle\Repository
 */
class SmileCronRepository extends EntityRepository
{
    /**
     * Identify of cron command is queued
     *
     * @param CronInterface $cron cron command
     * @return bool true if cron is already queued
     */
    public function isQueued(CronInterface $cron)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.alias = :alias')
            ->andWhere('c.ended is NULL')
            ->setParameter('alias', $cron->getAlias())
            ->getQuery();

        $result = $query->setMaxResults(1)->getOneOrNullResult();

        if ($result)
            return true;

        return false;
    }

    /**
     * Add cron to queued
     *
     * @param CronInterface $cron cron command
     */
    public function addQueued(CronInterface $cron)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.alias = :alias')
            ->setParameter('alias', $cron->getAlias())
            ->getQuery();

        /** @var SmileCron $smileCron */
        $smileCron = $query->setMaxResults(1)->getOneOrNullResult();

        if (!$smileCron) {
            $smileCron = new SmileCron();
            $smileCron->setAlias($cron->getAlias());
        }

        $now = new \DateTime('now');
        $smileCron->setQueued($now);
        $smileCron->setStarted(null);
        $smileCron->setEnded(null);
        $smileCron->setStatus(0);

        $this->getEntityManager()->persist($smileCron);
        $this->getEntityManager()->flush();
    }

    /**
     * List cron command queued
     *
     * @return SmileCron[] cron commands queued
     */
    public function listQueued()
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.started is NULL')
            ->getQuery();

        /** @var SmileCron[] $smileCrons */
        return $query->getResult();
    }

    /**
     * Run cron command
     *
     * @param SmileCron $smileCron cron command
     */
    public function run(SmileCron $smileCron)
    {
        $now = new \DateTime('now');
        $smileCron->setStarted($now);
        $this->getEntityManager()->persist($smileCron);
        $this->getEntityManager()->flush();
    }

    /**
     * End cron command
     *
     * @param SmileCron $smileCron cron command
     * @param int $status cron command status
     */
    public function end(SmileCron $smileCron, $status = 0)
    {
        $now = new \DateTime('now');
        $smileCron->setEnded($now);
        $smileCron->setStatus($status);
        $this->getEntityManager()->persist($smileCron);
        $this->getEntityManager()->flush();
    }

    /**
     * @return SmileCron[] cron list
     */
    public function listCrons()
    {
        $query = $this->createQueryBuilder('c')
            ->getQuery();

        /** @var SmileCron[] $smileCrons */
        return $query->getResult();
    }
}
