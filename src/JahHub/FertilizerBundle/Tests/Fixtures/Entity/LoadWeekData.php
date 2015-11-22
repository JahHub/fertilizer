<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\Week;

/**
 * Class LoadWeekData
 */
class LoadWeekData extends AbstractLoadEntityData
{
    const WEEK_1 = 'week1';
    const WEEK_2 = 'week2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::WEEK_1] = $this->createWeek(1);
        $entityList[self::WEEK_2] = $this->createWeek(2);

        $this->persistAndFlush($manager, $entityList);
    }


    /**
     * @param int $id
     *
     * @return Week
     */
    public function createWeek($id)
    {
        $week = new Week();
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
