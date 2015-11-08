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
    /**
     * {@inheritdoc}
     */
    public function exist($id)
    {
        return $this->getFertilizerObjectManager()->exist($id);
    }

    /**
     * @param int        $limit
     * @param int        $offset
     * @param array|null $orderBy
     *
     * @return Item[]
     */
    public function all($limit = 5, $offset = 0, $orderBy = null)
    {
        return $this->getFertilizerObjectManager()->all($limit, $offset, $orderBy);
    }

    /**
     * @param int $id
     *
     * @return Item
     */
    public function get($id)
    {
        return $this->getFertilizerObjectManager()->load($id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->getFertilizerObjectManager()->delete($id);
    }

    /**
     * @param array $parameters
     *
     * @return Item
     */
    public function post(array $parameters)
    {
        /** @var Item $item */
        $item = $this->getFertilizerObjectManager()->create();

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
     * @return Item
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