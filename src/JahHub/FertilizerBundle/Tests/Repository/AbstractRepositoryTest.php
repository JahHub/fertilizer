<?php
namespace JahHub\FertilizerBundle\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class AbstractRepositoryTest
 */
abstract class AbstractRepositoryTest extends WebTestCase
{

    const UNKNOWN_ID = 99999999999999999999;

    /** @var EntityManager */
    private $entityManager;
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->loadFixtures(array());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}
