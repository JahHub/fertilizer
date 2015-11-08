<?php
namespace JahHub\FertilizerBundle\Manager;

use Doctrine\ORM\EntityManager;
use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Repository\EntityRepositoryInterface;

/**
 * Class ObjectManager
 */
class ObjectManager
{
    /** @var EntityRepositoryInterface */
    private $repository;

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityRepositoryInterface $entityRepository
     * @param EntityManager             $entityManager
     */
    public function __construct(
        EntityRepositoryInterface $entityRepository,
        EntityManager $entityManager
    ) {
        $this->repository = $entityRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     *
     * @return EntityInterface
     */
    public function load($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->repository->delete($id);
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
        return $this->repository->all($limit, $offset, $orderBy);
    }

    /**
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id)
    {
        return $this->repository->exist($id);
    }

    /**
     * @return EntityInterface
     */
    public function create()
    {
        return $this->repository->create();
    }

    /**
     * @param EntityInterface[] $entities
     * @param int               $batchLimit default to 10
     */
    public function batchPersistAndFlush(array $entities, $batchLimit = 10)
    {
        $counter = 0;
        $entitiesToFlush = array();
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
            $entitiesToFlush[] = $entity;
            if (0 === ++$counter%$batchLimit) {
                $this->entityManager->flush($entitiesToFlush);
                $entitiesToFlush = array();
            }
        }
        if (0 !== $counter%$batchLimit) {
            $this->entityManager->flush($entitiesToFlush);
        }
    }
}
