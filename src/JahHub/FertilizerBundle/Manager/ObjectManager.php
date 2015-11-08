<?php
namespace JahHub\FertilizerBundle\Manager;

use Doctrine\Orm\EntityManager as DoctrineManager;
use Doctrine\Common\Persistence\ObjectRepository;
use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Class ObjectManager
 */
class ObjectManager
{
    /** @var ObjectRepository */
    private $repository;

    /** @var DoctrineManager */
    private $objectManager;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var string */
    private $entityClass;

    /**
     * @param DoctrineManager      $objectManager
     * @param string               $entityClass
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        DoctrineManager $objectManager,
        $entityClass,
        FormFactoryInterface $formFactory
    ) {
        $this->entityClass = $entityClass;
        $this->objectManager = $objectManager;
        $this->repository = $this->objectManager->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
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
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete($this->entityClass, 'entity')
            ->where('entity.id = :entity_id')
            ->setParameter('entity_id', $id);

        $qb->getQuery()->execute();
    }

    /**
     * Get a list of entity.
     *
     * @param int         $limit
     * @param int         $offset
     * @param string|null $orderBy
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $orderBy = null)
    {
        return $this->repository->findBy(array(), $orderBy, $limit, $offset);
    }

    /**
     * @param int $id
     *
     * @return boolean
     */
    public function exist($id)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->select('entity.id')
            ->from($this->entityClass, 'entity')
            ->where('entity.id = :entity_id')
            ->setParameter('entity_id', $id);

        $result = $qb->getQuery()->getArrayResult();

        return count($result) > 0;
    }

    /**
     * @return EntityInterface
     */
    public function create()
    {
        $className = $this->entityClass;

        return new $className();
    }

    /**
     * @param string|FormTypeInterface $form       The type of the form
     * @param EntityInterface          $entity     The initial data
     * @param array                    $parameters
     * @param string                   $method
     *
     * @return mixed the submitted entity
     */
    public function processForm($form, EntityInterface $entity, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create($form, $entity, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $submittedEntity = $form->getData();
            $this->batchPersistAndFlush(array($submittedEntity));

            return $submittedEntity;
        }

        throw new InvalidFormException(
            'Invalid submitted data',
            $form
        );
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
            $this->objectManager->persist($entity);
            $entitiesToFlush[] = $entity;
            if (0 === ++$counter%$batchLimit) {
                $this->objectManager->flush($entitiesToFlush);
                $entitiesToFlush = array();
            }
        }
        if (0 !== $counter%$batchLimit) {
            $this->objectManager->flush($entitiesToFlush);
        }
    }
}
