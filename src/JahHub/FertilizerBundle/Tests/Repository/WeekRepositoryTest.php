<?php
namespace JahHub\FertilizerBundle\Tests\Repository;

use JahHub\FertilizerBundle\Repository\WeekRepository;

/**
 * Class WeekRepositoryTest
 */
class WeekRepositoryTest extends AbstractRepositoryTest
{
    /** @var string */
    private $entityName = 'JahHubFertilizerBundle:Week';

    /** @var string */
    private $entityClassName = 'JahHub\FertilizerBundle\Entity\Week';

    /** @var WeekRepository */
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
        $class = 'JahHub\FertilizerBundle\Repository\WeekRepository';
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
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $this->assertTrue($this->repository->exist(1));
        $this->assertFalse($this->repository->exist(self::UNKNOWN_ID));
    }

    /**
     */
    public function testDelete()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $entityId = 1;
        $this->repository->delete($entityId);
        $this->assertFalse($this->repository->exist($entityId));
    }

    /**
     */
    public function testAll()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $limit = 2;
        $entityList = $this->repository->all(1, $limit);

        $this->assertCount($limit, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);

        $limit = 3;
        $entityList = $this->repository->all(1, $limit);

        $this->assertCount($limit, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);

        $entityList = $this->repository->all(0, 0);

        $this->assertCount(1, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);
    }
}
