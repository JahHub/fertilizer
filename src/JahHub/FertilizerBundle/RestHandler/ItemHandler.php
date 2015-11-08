<?php
namespace JahHub\FertilizerBundle\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Entity\Item;
use JahHub\FertilizerBundle\Manager\ObjectManager;

/**
 * Class ItemHandler
 */
class ItemHandler extends AbstractHandler
{
    /** @var ObjectManager */
    private $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exist($id)
    {
        return $this->objectManager->exist($id);
    }

    /**
     * Get a list of entity.
     *
     * @param int        $limit
     * @param int        $offset
     * @param array|null $orderBy
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $orderBy = null)
    {
        return $this->objectManager->all($limit, $offset, $orderBy);
    }

    /**
     * @param int $id
     *
     * @return Item
     */
    public function get($id)
    {
        return $this->objectManager->load($id);
    }

    /**
     * @param int $id
     *
     * @return Item
     */
    public function delete($id)
    {
        return $this->objectManager->delete($id);
    }

    /**
     * @param array $parameters
     *
     * @return Item
     */
    public function post(array $parameters)
    {
        /** @var Item $item */
        $item = $this->objectManager->create();

        return $this->processItemForm($item, $parameters, 'POST');
    }

    /**
     * @param EntityInterface $item
     * @param array           $parameters
     *
     * @return Item
     */
    public function put(EntityInterface $item, array $parameters)
    {
        return $this->processItemForm($item, $parameters, 'PUT');
    }

    /**
     * @param EntityInterface $item
     * @param array           $parameters
     *
     * @return Item
     */
    public function patch(EntityInterface $item, array $parameters)
    {
        return $this->processItemForm($item, $parameters, 'PATCH');
    }

    /**
     * @param EntityInterface $item
     * @param array           $parameters
     * @param string          $method
     *
     * @return mixed
     */
    private function processItemForm(EntityInterface $item, array $parameters, $method = "PUT")
    {
        return $this->processForm(
            'fertilizer_item',
            $item,
            $parameters,
            $method
        );
    }
}
