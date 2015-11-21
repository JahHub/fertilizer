<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\Item;

/**
 * Class LoadItemData
 */
class LoadItemData extends AbstractLoadEntityData
{
    const ITEM_1 = 'item1';
    const ITEM_2 = 'item2';
    const ITEM_3 = 'item3';
    const ITEM_4 = 'item4';
    const ITEM_5 = 'item5';
    const ITEM_6 = 'item6';
    const ITEM_7 = 'item7';
    const ITEM_8 = 'item8';
    const ITEM_9 = 'item9';
    const ITEM_10 = 'item10';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[self::ITEM_1] = $this->createItem(1, 'name_1');
        $entityList[self::ITEM_2] = $this->createItem(2, 'name_2');
        $entityList[self::ITEM_3] = $this->createItem(3, 'name_3');
        $entityList[self::ITEM_4] = $this->createItem(4, 'name_4');
        $entityList[self::ITEM_5] = $this->createItem(5, 'name_5');
        $entityList[self::ITEM_6] = $this->createItem(6, 'name_6');
        $entityList[self::ITEM_7] = $this->createItem(7, 'name_7');
        $entityList[self::ITEM_8] = $this->createItem(8, 'name_8');
        $entityList[self::ITEM_9] = $this->createItem(9, 'name_9');
        $entityList[self::ITEM_10] = $this->createItem(10, 'name_10');

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
