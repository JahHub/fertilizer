<?php
namespace AppBundle\Tests\Fixtures\Entity;

use AppBundle\Entity\Item;
use AppBundle\Entity\ItemQuantity;
use AppBundle\Entity\Week;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadItemQuantityItemQuantityData
 */
class LoadItemQuantityData extends AbstractLoadEntityData
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityList[] = $this->createItemQuantity(
            1,
            1,
            $this->getReference(LoadItemData::ITEM_1),
            $this->getReference(LoadWeekData::WEEK_1)
        );
        $entityList[] = $this->createItemQuantity(
            2,
            1,
            $this->getReference(LoadItemData::ITEM_1),
            $this->getReference(LoadWeekData::WEEK_1)
        );
        $entityList[] = $this->createItemQuantity(
            3,
            2,
            $this->getReference(LoadItemData::ITEM_2),
            $this->getReference(LoadWeekData::WEEK_1)
        );
        $entityList[] = $this->createItemQuantity(
            4,
            2,
            $this->getReference(LoadItemData::ITEM_2),
            $this->getReference(LoadWeekData::WEEK_2)
        );
        $entityList[] = $this->createItemQuantity(
            5,
            3,
            $this->getReference(LoadItemData::ITEM_3),
            $this->getReference(LoadWeekData::WEEK_2)
        );
        $entityList[] = $this->createItemQuantity(
            6,
            3,
            $this->getReference(LoadItemData::ITEM_3),
            $this->getReference(LoadWeekData::WEEK_2)
        );

        $this->persistAndFlush($manager, $entityList);
    }


    /**
     * @param int   $id
     * @param float $quantity
     * @param Item  $item
     * @param Week  $week
     *
     * @return ItemQuantity
     */
    public function createItemQuantity($id, $quantity, Item $item, Week $week)
    {
        $itemQuantity = new ItemQuantity();
        $itemQuantity->setQuantity($quantity);
        $itemQuantity->setItem($item);
        $itemQuantity->setWeek($week);
        $this->setEntityId($itemQuantity, $id);

        return $itemQuantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
