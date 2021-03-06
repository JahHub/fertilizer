<?php
namespace AppBundle\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interface EntityRepositoryInterface
 */
interface EntityRepositoryInterface extends ObjectRepository
{
    /**
     * Create a new object
     *
     * @return object The object.
     */
    public function create();

    /**
     * Check if an object exist by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     *
     * @return boolean
     */
    public function exist($id);

    /**
     * Delete an object by its primary key / identifier.
     *
     * @param mixed $id The identifier.
     */
    public function delete($id);

    /**
     * Get a list of object.
     *
     * @param int        $limit
     * @param int        $page
     * @param array|null $orderBy
     *
     * @return array
     */
    public function all($limit, $page = 1, $orderBy = null);
}
