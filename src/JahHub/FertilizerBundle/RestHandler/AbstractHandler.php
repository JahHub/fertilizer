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
    private $objectManager;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param ObjectManager        $objectManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ObjectManager $objectManager,
        FormFactoryInterface $formFactory
    ) {
        $this->objectManager = $objectManager;
        $this->formFactory = $formFactory;
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
            $this->objectManager->batchPersistAndFlush(array($submittedEntity));

            return $submittedEntity;
        }

        throw new InvalidFormException(
            'Invalid submitted data',
            $form
        );
    }
}
