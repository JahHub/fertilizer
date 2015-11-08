<?php
namespace JahHub\FertilizerBundle\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use JahHub\FertilizerBundle\Manager\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractHandler
 */
abstract class AbstractHandler implements RESTHandlerInterface
{
    /** @var ObjectManager */
    private $fertilizerObjectManager;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param ObjectManager        $fertilizerObjectManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ObjectManager $fertilizerObjectManager,
        FormFactoryInterface $formFactory
    ) {
        $this->fertilizerObjectManager = $fertilizerObjectManager;
        $this->formFactory = $formFactory;
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
     * @param FormInterface|string $form
     * @param EntityInterface      $entity
     * @param array                $parameters
     * @param string               $method
     *
     * @return mixed
     * @throws InvalidFormException
     */
    public function processForm($form, EntityInterface $entity, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create($form, $entity, array('method' => $method));
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
