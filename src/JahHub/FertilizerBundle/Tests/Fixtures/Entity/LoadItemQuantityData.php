<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use JahHub\FertilizerBundle\Entity\Item;
use JahHub\FertilizerBundle\Entity\ItemQuantity;

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
        $entityList[] = $this->createItemQuantity(1, 1, $this->getReference(LoadItemData::ITEM_1));
        $entityList[] = $this->createItemQuantity(2, 1, $this->getReference(LoadItemData::ITEM_1));
        $entityList[] = $this->createItemQuantity(3, 2, $this->getReference(LoadItemData::ITEM_2));
        $entityList[] = $this->createItemQuantity(4, 2, $this->getReference(LoadItemData::ITEM_2));
        $entityList[] = $this->createItemQuantity(5, 3, $this->getReference(LoadItemData::ITEM_3));
        $entityList[] = $this->createItemQuantity(6, 3, $this->getReference(LoadItemData::ITEM_3));

        $this->persistAndFlush($manager, $entityList);
    }


    /**
     * @param int   $id
     * @param float $quantity
     * @param Item  $item
     *
     * @return ItemQuantity
     */
    public function createItemQuantity($id, $quantity, Item $item)
    {
        $itemQuantity = new ItemQuantity();
        $itemQuantity->setQuantity($quantity);
        $itemQuantity->setItem($item);
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