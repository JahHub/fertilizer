<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\Item;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadItemData
 */
class LoadItemData extends AbstractLoadEntityData
{
    const ITEM_1 = 'item1';
    const ITEM_2 = 'item2';
    const ITEM_3 = 'item3';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::ITEM_1] = $this->createItem(1, 'name_1');
        $entityList[self::ITEM_2] = $this->createItem(2, 'name_2');
        $entityList[self::ITEM_3] = $this->createItem(3, 'name_3');

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

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
