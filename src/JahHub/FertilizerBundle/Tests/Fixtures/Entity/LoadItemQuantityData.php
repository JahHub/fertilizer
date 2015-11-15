<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\ObjectManager;
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
        $entityList[] = $this->createItemQuantity(1, 1);
        $entityList[] = $this->createItemQuantity(2, 2);
        $entityList[] = $this->createItemQuantity(3, 3);
        $entityList[] = $this->createItemQuantity(4, 4);
        $entityList[] = $this->createItemQuantity(5, 5);
        $entityList[] = $this->createItemQuantity(6, 6);
        $entityList[] = $this->createItemQuantity(7, 7);
        $entityList[] = $this->createItemQuantity(8, 8);
        $entityList[] = $this->createItemQuantity(9, 9);
        $entityList[] = $this->createItemQuantity(10, 10);

        $this->persistAndFlush($manager, $entityList);
    }


    /**
     * @param int   $id
     * @param float $quantity
     *
     * @return ItemQuantity
     */
    public function createItemQuantity($id, $quantity)
    {
        $itemQuantity = new ItemQuantity();
        $itemQuantity->setQuantity($quantity);
        $this->setEntityId($itemQuantity, $id);

        return $itemQuantity;
    }
}
