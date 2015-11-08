<?php
namespace JahHub\FertilizerBundle\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class AbstractRepositoryTest
 */
abstract class AbstractRepositoryTest extends WebTestCase
{

    /** @var EntityManager */
    private $entityManager;
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->loadFixtures(array());
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}
