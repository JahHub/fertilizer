<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\State;
use AppBundle\Entity\Week;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadWeekData
 */
class LoadWeekData extends AbstractLoadEntityData
{
    const WEEK_1 = 'week1';
    const WEEK_2 = 'week2';
    const WEEK_3 = 'week3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::WEEK_1] = $this->createWeek(
            1,
            1,
            $this->getReference(LoadStateData::STATE_1)
        );
        $entityList[self::WEEK_2] = $this->createWeek(
            2,
            2,
            $this->getReference(LoadStateData::STATE_2)
        );
        $entityList[self::WEEK_3] = $this->createWeek(
            3,
            3,
            $this->getReference(LoadStateData::STATE_2)
        );

        $this->persistAndFlush($manager, $entityList);
    }


    /**
     * @param int   $id
     * @param int   $number
     * @param State $state
     *
     * @return Week
     */
    public function createWeek($id, $number, State $state)
    {
        $week = new Week();
        $week->setNumber($number);
        $week->setState($state);
        $this->setEntityId($week, $id);

        return $week;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
