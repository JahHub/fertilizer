<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\RestHandler\AbstractHandler;

/**
 * Class AbstractHandlerMock
 */
class AbstractHandlerMock extends AbstractHandler
{
    /**
     * Get an object.
     *
     * @param int $id
     *
     * @return EntityInterface
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * Create a new object.
     *
     * @param array $parameters
     *
     * @return EntityInterface
     */
    public function post(array $parameters)
    {
        // TODO: Implement post() method.
    }

    /**
     * Edit a object, or create if not exist.
     *
     * @param EntityInterface $object
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function put(EntityInterface $object, array $parameters)
    {
        // TODO: Implement put() method.
    }

    /**
     * Partially update an object.
     *
     * @param EntityInterface $object
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function patch(EntityInterface $object, array $parameters)
    {
        // TODO: Implement patch() method.
    }

    /**
     * Delete an object
     *
     * @param int $id
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Get a list of object.
     *
     * @param int        $limit
     * @param int        $offset
     * @param array|null $orderBy
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $orderBy = null)
    {
        // TODO: Implement all() method.
    }

    /**
     * Check if an object exist
     *
     * @param int $id
     *
     * @return bool
     */
    public function exist($id)
    {
        // TODO: Implement exist() method.
    }


}
