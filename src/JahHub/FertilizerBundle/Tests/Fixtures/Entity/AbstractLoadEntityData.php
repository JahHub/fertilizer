<?php
namespace JahHub\FertilizerBundle\Tests\Fixtures\Entity;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use JahHub\FertilizerBundle\Entity\State;

/**
 * Class AbstractLoadEntityData
 */
abstract class AbstractLoadEntityData implements FixtureInterface
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
        foreach ($entities as $entity) {
            $manager->persist($entity);

            /** @var ClassMetadata $metadata */
            $metadata = $manager->getClassMetaData(get_class($entity));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $metadata->setIdGenerator(new AssignedGenerator());
        }

        $manager->flush();
    }
}
