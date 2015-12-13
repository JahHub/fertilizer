<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\State;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadStateData
 */
class LoadStateData extends AbstractLoadEntityData
{
    const STATE_1 = 'state1';
    const STATE_2 = 'state2';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::STATE_1] = $this->createState(1, 'name_1');
        $entityList[self::STATE_2] = $this->createState(2, 'name_2');

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
