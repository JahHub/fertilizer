<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\Schedule;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadScheduleData
 */
class LoadScheduleData extends AbstractLoadEntityData
{
    const SCHEDULE_1 = 'schedule1';
    const SCHEDULE_2 = 'schedule2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::SCHEDULE_1] = $this->createSchedule(
            1,
            'name_1',
            array(
                $this->getReference(LoadStateData::STATE_1),
                $this->getReference(LoadStateData::STATE_2),
            )
        );
        $entityList[self::SCHEDULE_2] = $this->createSchedule(2, 'name_2', array());

        $this->persistAndFlush($manager, $entityList);
    }

    /**
     * @param string  $id
     * @param string  $name
     * @param State[] $stateList
     *
     * @return Schedule
     */
    public function createSchedule($id, $name, array $stateList)
    {
        $schedule = new Schedule();
        $schedule->setName($name);
        $schedule->setStateList($stateList);
        $this->setEntityId($schedule, $id);

        return $schedule;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
