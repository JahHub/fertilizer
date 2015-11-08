<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Manager\ObjectManager;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractHandlerTest
 */
class AbstractHandlerTest extends \PHPUnit_Framework_TestCase
{

    /** @var AbstractHandlerMock */
    protected $handler;

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
        $this->handler = new AbstractHandlerMock(
            $this->fertilizerObjectManager->reveal(),
            $this->formFactory->reveal()
        );
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
        $formName = 'test_type';
        $method = 'POST';
        $parameters = array();
        /** @var FormInterface|ObjectProphecy $form */
        $form = $this->prophesize('Symfony\Component\Form\FormInterface');
        /** @var EntityInterface|ObjectProphecy $submittedEntity */
        $submittedEntity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');

        $this->prophesizeProcessFormOk($formName, $entity, $method, $form, $parameters, $submittedEntity);

        $this->assertSame(
            $submittedEntity->reveal(),
            $this->handler->processForm($formName, $entity->reveal(), $parameters, $method)
        );
    }

    /**
     */
    public function testProcessFormKo()
    {
        $formName = 'test_type';
        $method = 'POST';
        $parameters = array();
        /** @var FormInterface|ObjectProphecy $form */
        $form = $this->prophesize('Symfony\Component\Form\FormInterface');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');

        $this->prophesizeProcessFormKo($formName, $entity, $method, $form, $parameters);

        $this->setExpectedException(
            'JahHub\FertilizerBundle\Exception\InvalidFormException',
            'Invalid submitted data'
        );

        $this->handler->processForm($formName, $entity->reveal(), $parameters, $method);
    }

    /**
     * @param string         $formName
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     * @param ObjectProphecy $submittedEntity
     */
    protected function prophesizeProcessFormOk(
        $formName,
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters,
        ObjectProphecy $submittedEntity
    ) {
        $this->prophesizeProcessFormFirstPart($formName, $entity, $method, $form, $parameters);
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
     * @param string         $formName
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     */
    protected function prophesizeProcessFormKo(
        $formName,
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters
    ) {
        $this->prophesizeProcessFormFirstPart($formName, $entity, $method, $form, $parameters);
        $form->isValid()
            ->willReturn(false)
            ->shouldBeCalledTimes(1);
    }

    /**
     * @param string         $formName
     * @param ObjectProphecy $entity
     * @param string         $method
     * @param ObjectProphecy $form
     * @param array          $parameters
     */
    protected function prophesizeProcessFormFirstPart(
        $formName,
        ObjectProphecy $entity,
        $method,
        ObjectProphecy $form,
        array $parameters
    ) {
        $this->formFactory->create($formName, $entity->reveal(), array('method' => $method))
            ->willReturn($form->reveal())
            ->shouldBeCalledTimes(1);
        $form->submit($parameters, 'PATCH' !== $method)
            ->shouldBeCalledTimes(1);
    }
}
