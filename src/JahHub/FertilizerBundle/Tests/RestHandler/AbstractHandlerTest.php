<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Manager\ObjectManager;
use JahHub\FertilizerBundle\RestHandler\AbstractHandler;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractHandlerTest
 */
abstract class AbstractHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractHandler */
    protected $handler;

    /** @var string */
    protected $formTypeName;

    /** @var ObjectManager|ObjectProphecy */
    protected $fertilizerObjectManager;

    /** @var FormFactoryInterface|ObjectProphecy */
    protected $formFactory;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->fertilizerObjectManager  = $this->prophesize('JahHub\FertilizerBundle\Manager\ObjectManager');
        $this->formFactory = $this->prophesize('Symfony\Component\Form\FormFactoryInterface');
    }

    /**
     */
    public function testGetFertilizerObjectManager()
    {
        $this->assertSame(
            $this->fertilizerObjectManager->reveal(),
            $this->handler->getFertilizerObjectManager()
        );
    }

    /**
     */
    public function testGetFormFactory()
    {
        $this->assertSame(
            $this->formFactory->reveal(),
            $this->handler->getFormFactory()
        );
    }

    /**
     */
    public function testProcessFormOk()
    {
        $method = 'POST';
        $parameters = array();
        /** @var FormInterface|ObjectProphecy $form */
        $form = $this->prophesize('Symfony\Component\Form\FormInterface');
        /** @var EntityInterface|ObjectProphecy $submittedEntity */
        $submittedEntity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');

        $this->prophesizeProcessFormOk($entity, $method, $form, $parameters, $submittedEntity);

        $this->assertSame(
            $submittedEntity->reveal(),
            $this->handler->processForm($entity->reveal(), $parameters, $method)
        );
    }

    /**
     */
    public function testProcessFormKo()
    {
        $method = 'POST';
        $parameters = array();
        /** @var FormInterface|ObjectProphecy $form */
        $form = $this->prophesize('Symfony\Component\Form\FormInterface');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');

        $this->prophesizeProcessFormKo($entity, $method, $form, $parameters);

        $this->setExpectedException(
            'JahHub\FertilizerBundle\Exception\InvalidFormException',
            'Invalid submitted data'
        );

        $this->handler->processForm($entity->reveal(), $parameters, $method);
    }

    /**
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     * @param ObjectProphecy $submittedEntity
     */
    protected function prophesizeProcessFormOk(
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters,
        ObjectProphecy $submittedEntity
    ) {
        $this->prophesizeProcessFormFirstPart($this->formTypeName, $entity, $method, $form, $parameters);
        $form->isValid()
            ->willReturn(true)
            ->shouldBeCalledTimes(1);
        $form->getData()
            ->willReturn($submittedEntity->reveal())
            ->shouldBeCalledTimes(1);
        $this->fertilizerObjectManager->batchPersistAndFlush(array($submittedEntity->reveal()))
            ->shouldBeCalledTimes(1);
    }

    /**
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     */
    protected function prophesizeProcessFormKo(
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters
    ) {
        $this->prophesizeProcessFormFirstPart($this->formTypeName, $entity, $method, $form, $parameters);
        $form->isValid()
            ->willReturn(false)
            ->shouldBeCalledTimes(1);
    }

    /**
     * @param string         $formTypeName
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     */
    protected function prophesizeProcessFormFirstPart(
        $formTypeName,
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters
    ) {
        $this->formFactory->create($formTypeName, $entity->reveal(), array('method' => $method))
            ->willReturn($form->reveal())
            ->shouldBeCalledTimes(1);
        $form->submit($parameters, 'PATCH' !== $method)
            ->shouldBeCalledTimes(1);
    }
}
