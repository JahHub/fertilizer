<?php
namespace AppBundle\Tests\Repository;

use AppBundle\Repository\StateRepository;

/**
 * Class StateRepositoryTest
 */
class StateRepositoryTest extends AbstractRepositoryTest
{
    /** @var string */
    private $entityName = 'AppBundle:State';

    /** @var string */
    private $entityClassName = 'AppBundle\Entity\State';

    /** @var StateRepository */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getEntityManager()->getRepository($this->entityName);
    }

    /**
     */
    public function testRepositoryClass()
    {
        $class = 'AppBundle\Repository\StateRepository';
        $this->assertInstanceOf(
            $class,
            $this->repository,
            sprintf(
                'Repository class must be %s',
                $class
            )
        );
    }

    /**
     */
    public function testCreate()
    {
        $entity = $this->repository->create();

        $this->assertInstanceOf(
            $this->entityClassName,
            $entity
        );
    }

    /**
     */
    public function testExist()
    {
        $this->loadFixtures(array('AppBundle\Tests\Fixtures\Entity\LoadStateData'));

        $this->assertTrue($this->repository->exist(1));
        $this->assertFalse($this->repository->exist(self::UNKNOWN_ID));
    }

    /**
     */
    public function testDelete()
    {
        $this->loadFixtures(array('AppBundle\Tests\Fixtures\Entity\LoadStateData'));

        $entityId = 1;
        $this->repository->delete($entityId);
        $this->assertFalse($this->repository->exist($entityId));
    }

    /**
     */
    public function testAll()
    {
        $this->loadFixtures(array('AppBundle\Tests\Fixtures\Entity\LoadStateData'));

        $limit = 2;
        $entityList = $this->repository->all(1, $limit);

        $this->assertCount($limit, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);

        $limit = 3;
        $entityList = $this->repository->all(1, $limit);

        $this->assertCount(2, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);

        $entityList = $this->repository->all(0, 0);

        $this->assertCount(1, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);
    }
}
