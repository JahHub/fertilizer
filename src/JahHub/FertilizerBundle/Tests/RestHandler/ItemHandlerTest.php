<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\RestHandler\ItemHandler;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormInterface;

/**
 * Class InvalidFormExceptionTest
 */
class ItemHandlerTest extends AbstractHandlerTest
{

    /** @var ItemHandler */
    protected $handler;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->formName = 'fertilizer_item';
        $this->handler = new ItemHandler(
            $this->fertilizerObjectManager->reveal(),
            $this->formFactory->reveal()
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

        $this->prophesizeProcessFormOk($this->formName, $entity, $method, $form, $parameters, $submittedEntity);

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

        $this->prophesizeProcessFormOk($this->formName, $entity, $method, $form, $parameters, $submittedEntity);

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

        $this->prophesizeProcessFormOk($this->formName, $entity, $method, $form, $parameters, $submittedEntity);

        $this->assertSame(
            $submittedEntity->reveal(),
            $this->handler->patch($entity->reveal(), $parameters)
        );
    }
}
