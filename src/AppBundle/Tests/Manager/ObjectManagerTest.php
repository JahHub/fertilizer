<?php
namespace AppBundle\Tests\Manager;

use AppBundle\Entity\EntityInterface;
use AppBundle\Manager\ObjectManager;
use AppBundle\Repository\EntityRepositoryInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager as DoctrineObjectManager;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Class ObjectManagerTest
 */
class ObjectManagerTest extends \PHPUnit_Framework_TestCase
{

    /** @var ObjectManager */
    private $manager;

    /** @var EntityRepositoryInterface|ObjectProphecy */
    private $repository;

    /** @var ManagerRegistry|ObjectProphecy */
    private $managerRegistry;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository  = $this->prophesize('AppBundle\Repository\EntityRepositoryInterface');
        $this->managerRegistry = $this->prophesize('Doctrine\Common\Persistence\ManagerRegistry');
        $this->manager = new ObjectManager(
            $this->repository->reveal(),
            $this->managerRegistry->reveal()
        );
    }

    /**
     */
    public function testLoad()
    {
        $id = 1;
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('AppBundle\Entity\EntityInterface');
        $this->repository->find($id)
            ->willReturn($entity->reveal())
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $entity->reveal(),
            $this->manager->load($id)
        );
    }

    /**
     */
    public function testDelete()
    {
        $id = 1;
        $this->repository->delete($id)
            ->shouldBeCalledTimes(1);

        $this->manager->delete($id);
    }

    /**
     */
    public function testAll()
    {
        $limit = 10;
        $offset = 0;
        $orderBy = null;
        /** @var EntityInterface|ObjectProphecy $entity1 */
        $entity1 = $this->prophesize('AppBundle\Entity\EntityInterface');
        /** @var EntityInterface|ObjectProphecy $entity2 */
        $entity2 = $this->prophesize('AppBundle\Entity\EntityInterface');
        $entityList = array(
            $entity1->reveal(),
            $entity2->reveal(),
        );
        $this->repository->all($limit, $offset, $orderBy)
            ->willReturn($entityList)
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $entityList,
            $this->manager->all($limit, $offset, $orderBy)
        );
    }

    /**
     */
    public function testExist()
    {
        $id = 1;
        $exist = true;
        $this->repository->exist($id)
            ->willReturn($exist)
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $exist,
            $this->manager->exist($id)
        );
    }

    /**
     */
    public function testCreate()
    {
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('AppBundle\Entity\EntityInterface');
        $this->repository->create()
            ->willReturn($entity->reveal())
            ->shouldBeCalledTimes(1);

        $this->assertSame(
            $entity->reveal(),
            $this->manager->create()
        );
    }

    /**
     */
    public function testPersistAndFlush()
    {
        $className = 'AppBundle\Entity\EntityInterface';
        /** @var DoctrineObjectManager|ObjectProphecy $manager */
        $manager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');
        /** @var EntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize('AppBundle\Entity\EntityInterface');

        $this->repository->getClassName()
            ->willReturn($className)
            ->shouldBeCalledTimes(1);

        $this->managerRegistry->getManagerForClass($className)
            ->willReturn($manager->reveal())
            ->shouldBeCalledTimes(1);

        $manager->persist($entity->reveal())
            ->shouldBeCalledTimes(1);

        $manager->flush(array($entity->reveal()))
            ->shouldBeCalledTimes(1);

        $this->manager->persistAndFlush($entity->reveal());
    }

    /**
     * @dataProvider getTestBatchPersistAndFlushData
     * @param int   $batchLimit
     * @param array $entityList
     * @param array $entitiesToFlushList
     */
    public function testBatchPersistAndFlush($batchLimit, array $entityList, array $entitiesToFlushList)
    {
        $className = 'AppBundle\Entity\EntityInterface';
        /** @var DoctrineObjectManager|ObjectProphecy $manager */
        $manager = $this->prophesize('Doctrine\Common\Persistence\ObjectManager');

        $this->repository->getClassName()
            ->willReturn($className)
            ->shouldBeCalledTimes(1);

        $this->managerRegistry->getManagerForClass($className)
            ->willReturn($manager->reveal())
            ->shouldBeCalledTimes(1);

        foreach ($entityList as $entity) {
            $manager->persist($entity)
                ->shouldBeCalledTimes(1);
        }

        foreach ($entitiesToFlushList as $entitiesToFlush) {
            $manager->flush($entitiesToFlush)
                ->shouldBeCalledTimes(1);
        }

        $this->manager->batchPersistAndFlush($entityList, $batchLimit);
    }

    /**
     * @return array
     */
    public function getTestBatchPersistAndFlushData()
    {
        $entity1 = $this->prophesize('AppBundle\Entity\EntityInterface');
        $entity2 = $this->prophesize('AppBundle\Entity\EntityInterface');
        $entity3 = $this->prophesize('AppBundle\Entity\EntityInterface');
        $entityList = array(
            $entity1->reveal(),
            $entity2->reveal(),
            $entity3->reveal(),
        );

        return array(
            'default limit' => array(
                10,
                $entityList,
                array(
                    $entityList,
                ),
            ),
            'custom limit' => array(
                2,
                $entityList,
                array(
                    array(
                        $entity1->reveal(),
                        $entity2->reveal(),
                    ),
                    array(
                        $entity3->reveal(),
                    ),
                ),
            ),
        );
    }
}
