<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
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
