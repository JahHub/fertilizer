<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\Item;
use JahHub\FertilizerBundle\Entity\State;
use JahHub\FertilizerBundle\Entity\Week;

/**
 * Class LoadItemData
 */
class LoadItemData extends AbstractLoadEntityData
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[] = $this->createItem(1, 'name_1');
        $entityList[] = $this->createItem(2, 'name_2');
        $entityList[] = $this->createItem(3, 'name_3');
        $entityList[] = $this->createItem(4, 'name_4');
        $entityList[] = $this->createItem(5, 'name_5');
        $entityList[] = $this->createItem(6, 'name_6');
        $entityList[] = $this->createItem(7, 'name_7');
        $entityList[] = $this->createItem(8, 'name_8');
        $entityList[] = $this->createItem(9, 'name_9');
        $entityList[] = $this->createItem(10, 'name_10');

        $this->persistAndFlush($manager, $entityList);
    }

    /**
     * @param string $id
     * @param string $name
     *
     * @return Item
     */
    public function createItem($id, $name)
    {
        $item = new Item();
        $item->setName($name);
        $this->setEntityId($item, $id);

        return $item;
    }
}
