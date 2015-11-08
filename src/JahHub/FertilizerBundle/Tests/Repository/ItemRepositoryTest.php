<?php
namespace JahHub\FertilizerBundle\Tests\Repository;

use JahHub\FertilizerBundle\Repository\ItemRepository;

/**
 * Class ItemRepositoryTest
 */
class ItemRepositoryTest extends AbstractRepositoryTest
{
    /** @var string */
    private $entityName = 'JahHubFertilizerBundle:Item';

    /** @var string */
    private $entityClassName = 'JahHub\FertilizerBundle\Entity\Item';

    /** @var ItemRepository */
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
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData'));

        $this->assertTrue($this->repository->exist(1));
        $this->assertFalse($this->repository->exist(99999999999999));
    }

    /**
     */
    public function testDelete()
    {
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData'));

        $entityId = 1;
        $this->repository->delete($entityId);
        $this->assertFalse($this->repository->exist($entityId));
    }

    /**
     */
    public function testAll()
    {
        $this->loadFixtures(array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData'));

        $limit = 2;
        $entityList = $this->repository->all($limit);

        $this->assertCount($limit, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);

        $limit = 2;
        $entityList = $this->repository->all($limit, 2);

        $this->assertCount(1, $entityList);
        $this->assertContainsOnlyInstancesOf($this->entityClassName, $entityList);
    }
}