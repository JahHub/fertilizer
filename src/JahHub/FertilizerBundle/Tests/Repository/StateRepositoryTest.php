<?php
namespace JahHub\FertilizerBundle\Tests\Repository;

use JahHub\FertilizerBundle\Repository\StateRepository;

/**
 * Class StateRepositoryTest
 */
class StateRepositoryTest extends AbstractRepositoryTest
{
    /** @var string */
    private $entityName = 'JahHubFertilizerBundle:State';

    /** @var string */
    private $entityClassName = 'JahHub\FertilizerBundle\Entity\State';

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
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData'));

        $this->assertTrue($this->repository->exist(1));
        $this->assertFalse($this->repository->exist(self::UNKNOWN_ID));
    }

    /**
     */
    public function testDelete()
    {
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData'));

        $entityId = 1;
        $this->repository->delete($entityId);
        $this->assertFalse($this->repository->exist($entityId));
    }

    /**
     */
    public function testAll()
    {
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData'));

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
