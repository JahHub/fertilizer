<?php
namespace AppBundle\Tests\Repository;

use Doctrine\ORM\EntityManager;
use AppBundle\Tests\WebParaTestCase;

/**
 * Class AbstractRepositoryTest
 */
abstract class AbstractRepositoryTest extends WebParaTestCase
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
        self::bootKernel(array(
            'environment' => $this->getEnvironment(),
        ));
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
