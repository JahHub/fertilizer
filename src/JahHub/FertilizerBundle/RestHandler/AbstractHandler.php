<?php
namespace JahHub\FertilizerBundle\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use JahHub\FertilizerBundle\Manager\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Class AbstractHandler
 */
abstract class AbstractHandler implements RESTHandlerInterface
{
    /** @var ObjectManager */
    private $fertilizerObjectManager;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var string */
    private $formTypeAlias;

    /**
     * @param ObjectManager        $fertilizerObjectManager
     * @param FormFactoryInterface $formFactory
     * @param string               $formTypeAlias
     */
    public function __construct(
        ObjectManager $fertilizerObjectManager,
        FormFactoryInterface $formFactory,
        $formTypeAlias
    ) {
        $this->fertilizerObjectManager = $fertilizerObjectManager;
        $this->formFactory = $formFactory;
        $this->formTypeAlias = $formTypeAlias;
    }

    /**
     * @return ObjectManager
     */
    public function getFertilizerObjectManager()
    {
        return $this->fertilizerObjectManager;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function exist($id)
    {
        return $this->getFertilizerObjectManager()->exist($id);
    }

    /**
     * @param int        $page
     * @param int        $limit
     * @param array|null $orderBy
     *
     * @return EntityInterface[]
     */
    public function all($page = 1, $limit = 5, $orderBy = null)
    {
        return $this->getFertilizerObjectManager()->all($page, $limit, $orderBy);
    }

    /**
     * @param int $id
     *
     * @return EntityInterface
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
     * @return EntityInterface
     */
    public function post(array $parameters)
    {
        /** @var EntityInterface $entity */
        $entity = $this->getFertilizerObjectManager()->create();

        return $this->processForm($entity, $parameters, 'POST');
    }

    /**
     * @param EntityInterface $entity
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function put(EntityInterface $entity, array $parameters)
    {
        return $this->processForm($entity, $parameters, 'PUT');
    }

    /**
     * @param EntityInterface $entity
     * @param array           $parameters
     *
     * @return EntityInterface
     */
    public function patch(EntityInterface $entity, array $parameters)
    {
        return $this->processForm($entity, $parameters, 'PATCH');
    }

    /**
     * @param EntityInterface $entity
     * @param array           $parameters
     * @param string          $method
     *
     * @return mixed
     * @throws InvalidFormException
     */
    public function processForm(EntityInterface $entity, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create($this->formTypeAlias, $entity, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $submittedEntity = $form->getData();
            $this->fertilizerObjectManager->batchPersistAndFlush(array($submittedEntity));

            return $submittedEntity;
        }

        throw new InvalidFormException(
            'Invalid submitted data',
            $form
        );
    }
}
