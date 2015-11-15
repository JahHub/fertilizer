<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use Doctrine\ORM\Mapping\Entity;
use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Manager\ObjectManager;
use JahHub\FertilizerBundle\Handler\EntityHandler;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class AbstractEntityHandlerTest
 */
abstract class AbstractEntityHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EntityHandler */
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
        $this->handler = new EntityHandler(
            $this->fertilizerObjectManager->reveal(),
            $this->formFactory->reveal(),
            $this->formTypeName
        );
    }

    /**
     */
    public function testExist()
    {
        $id = 1;
        $this->fertilizerObjectManager->exist($id)
            ->willReturn(true)
            ->shouldBeCalledTimes(1);

        $this->assertTrue($this->handler->exist($id));
    }

    /**
     */
    public function testAll()
    {
        $limit = 4;
        $offset = 0;
        $orderBy = null;
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity  = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');
        $entityList = array($entity->reveal());
        $this->fertilizerObjectManager->all($limit, $offset, $orderBy)
            ->willReturn($entityList)
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $entityList,
            $this->handler->all($limit, $offset, $orderBy)
        );
    }

    /**
     */
    public function testGet()
    {
        $id = 1;
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity  = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');
        $this->fertilizerObjectManager->load($id)
            ->willReturn($entity->reveal())
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $entity->reveal(),
            $this->handler->get($id)
        );
    }

    /**
     */
    public function testDelete()
    {
        $id = 1;
        $this->fertilizerObjectManager->delete($id)
            ->shouldBeCalledTimes(1);

        $this->handler->delete($id);
    }

    /**
     */
    public function testPost()
    {
        $method = 'POST';
        $parameters = array();
        /** @var FormInterface|ObjectProphecy $form */
        $form = $this->prophesize('Symfony\Component\Form\FormInterface');
        /** @var EntityInterface|ObjectProphecy $submittedEntity */
        $submittedEntity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('JahHub\FertilizerBundle\Entity\EntityInterface');

        $this->fertilizerObjectManager->create()
            ->willReturn($entity->reveal())
            ->shouldBeCalledTimes(1);

        $this->prophesizeProcessFormOk($entity, $method, $form, $parameters, $submittedEntity);

        $this->assertSame(
            $submittedEntity->reveal(),
            $this->handler->post($parameters)
        );
    }

    /**
     */
    public function testPut()
    {
        $method = 'PUT';
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
            $this->handler->put($entity->reveal(), $parameters)
        );
    }

    /**
     */
    public function testPatch()
    {
        $method = 'PATCH';
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
            $this->handler->patch($entity->reveal(), $parameters)
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
