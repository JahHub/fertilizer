<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\Week;

/**
 * Class LoadWeekData
 */
class LoadWeekData extends AbstractLoadEntityData
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[] = $this->createWeek(1);
        $entityList[] = $this->createWeek(2);
        $entityList[] = $this->createWeek(3);
        $entityList[] = $this->createWeek(4);
        $entityList[] = $this->createWeek(5);
        $entityList[] = $this->createWeek(6);
        $entityList[] = $this->createWeek(7);
        $entityList[] = $this->createWeek(8);
        $entityList[] = $this->createWeek(9);
        $entityList[] = $this->createWeek(10);

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
}
