<?php
namespace JahHub\FertilizerBundle\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;

/**
 * Class StateHandler
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
}
