<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\State;
use JahHub\FertilizerBundle\Entity\Week;

/**
 * Class LoadStateData
 */
class LoadStateData extends AbstractLoadEntityData
{
    const STATE_1 = 'state1';
    const STATE_2 = 'state2';
    const STATE_3 = 'state3';
    const STATE_4 = 'state4';
    const STATE_5 = 'state5';
    const STATE_6 = 'state6';
    const STATE_7 = 'state7';
    const STATE_8 = 'state8';
    const STATE_9 = 'state9';
    const STATE_10 = 'state10';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::STATE_1] = $this->createState(1, 'name_1');
        $entityList[self::STATE_2] = $this->createState(2, 'name_2');
        $entityList[self::STATE_3] = $this->createState(3, 'name_3');
        $entityList[self::STATE_4] = $this->createState(4, 'name_4');
        $entityList[self::STATE_5] = $this->createState(5, 'name_5');
        $entityList[self::STATE_6] = $this->createState(6, 'name_6');
        $entityList[self::STATE_7] = $this->createState(7, 'name_7');
        $entityList[self::STATE_8] = $this->createState(8, 'name_8');
        $entityList[self::STATE_9] = $this->createState(9, 'name_9');
        $entityList[self::STATE_10] = $this->createState(10, 'name_10');

        $this->persistAndFlush($manager, $entityList);
    }

    /**
     * @param string $id
     * @param string $name
     *
     * @return State
     */
    public function createState($id, $name)
    {
        $state = new State();
        $state->setName($name);
        $this->setEntityId($state, $id);

        return $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
