<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\State;

/**
 * Class LoadStateData
 */
class LoadStateData extends AbstractLoadEntityData
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[] = $this->createState(1, 'name_1');
        $entityList[] = $this->createState(2, 'name_2');
        $entityList[] = $this->createState(3, 'name_3');
        $entityList[] = $this->createState(4, 'name_4');
        $entityList[] = $this->createState(5, 'name_5');
        $entityList[] = $this->createState(6, 'name_6');
        $entityList[] = $this->createState(7, 'name_7');
        $entityList[] = $this->createState(8, 'name_8');
        $entityList[] = $this->createState(9, 'name_9');
        $entityList[] = $this->createState(10, 'name_10');

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
}
