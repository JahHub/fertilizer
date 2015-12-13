<?php
namespace AppBundle\Tests\Fixtures\Entity;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AbstractLoadEntityData
 */
abstract class AbstractLoadEntityData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param object $entity
     * @param int    $id
     * @param string $idPropertyName 'id' by default
     */
    public function setEntityId($entity, $id, $idPropertyName = 'id')
    {
        $idReflectionProperty = new \ReflectionProperty($entity, $idPropertyName);
        $idReflectionProperty->setAccessible(true);
        $idReflectionProperty->setValue($entity, $id);
    }

    /**
     * @param ObjectManager $manager
     * @param array         $entities
     */
    public function persistAndFlush(ObjectManager $manager, array $entities)
    {
        foreach ($entities as $key => $entity) {
            $manager->persist($entity);

            /** @var ClassMetadata $metadata */
            $metadata = $manager->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->flush($entity);

            if (is_string($key)) {
                $this->addReference($key, $entity);
            }
        }
        $manager->flush();
    }
}
