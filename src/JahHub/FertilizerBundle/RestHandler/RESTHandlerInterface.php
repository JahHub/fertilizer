<?php
namespace JahHub\FertilizerBundle\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;

/**
 * Interface RESTHandlerInterface
 */
interface RESTHandlerInterface
{
    /**
     * Get an object.
     *
     * @param int $id
     *
     * @return EntityInterface
     */
    public function get($id);

    /**
     * Create a new object.
     *
     * @param array $parameters
     *
     * @return EntityInterface
     */
    public function post(array $parameters);

    /**
     * Edit a object, or create if not exist.
     *
     * @param EntityInterface $object
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function put(EntityInterface $object, array $parameters);

    /**
     * Partially update an object.
     *
     * @param EntityInterface $object
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function patch(EntityInterface $object, array $parameters);

    /**
     * Delete an object
     *
     * @param int $id
     */
    public function delete($id);

    /**
     * Get a list of object.
     *
     * @param int        $page
     * @param int        $limit
     * @param array|null $orderBy
     *
     * @return array
     */
    public function all($page = 1, $limit = 5, $orderBy = null);

    /**
     * Check if an object exist
     *
     * @param int $id
     *
     * @return bool
     */
    public function exist($id);
}
