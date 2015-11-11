<?php
namespace JahHub\FertilizerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ItemRepository
 */
class ItemRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $className = $this->getClassName();

        return new $className();
    }

    /**
     * {@inheritdoc}
     */
    public function exist($id)
    {
        $qb = $this->createQueryBuilder('item');
        $qb->select('item.id')
            ->where('item.id = :item_id')
            ->setParameter('item_id', $id);

        $result = $qb->getQuery()->getArrayResult();

        return count($result) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $qb = $this->createQueryBuilder('item');
        $qb->delete($this->getClassName(), 'item')
            ->where('item.id = :item_id')
            ->setParameter('item_id', $id);

        $qb->getQuery()->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function all($page = 1, $limit = 5, $orderBy = null)
    {
        if ($limit < 1) {
            $limit = 1;
        }
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page >= 1 ? $page - 1 : 1) * $limit;

        return $this->findBy(array(), $orderBy, $limit, $offset);
    }
}
