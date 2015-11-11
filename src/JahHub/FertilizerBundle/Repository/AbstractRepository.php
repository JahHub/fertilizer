<?php
namespace JahHub\FertilizerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository extends EntityRepository implements EntityRepositoryInterface
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
        $qb = $this->createQueryBuilder('entity');
        $qb->select('entity.id')
            ->where('entity.id = :entity_id')
            ->setParameter('entity_id', $id);

        $result = $qb->getQuery()->getArrayResult();

        return count($result) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->delete($this->getClassName(), 'entity')
            ->where('entity.id = :entity_id')
            ->setParameter('entity_id', $id);

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
            $offset = 0;
        } else {
            $offset = ($page - 1) * $limit;
        }

        return $this->findBy(array(), $orderBy, $limit, $offset);
    }
}
