<?php

namespace JahHub\FertilizerBundle\Tests\DependencyInjection;

use JahHub\FertilizerBundle\DependencyInjection\JahHubFertilizerExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class JahHubFertilizerExtensionTest
 */
class JahHubFertilizerExtensionTest extends AbstractExtensionTestCase
{
    /**
     */
    public function testEntityClassConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
        );

        foreach ($entityNameList as $entityName) {
            $classParameterKey = sprintf(
                'jahhub_fertilizer.entity.%s.class',
                $entityName
            );
            $this->assertContainerBuilderHasParameter($classParameterKey);

            $this->assertTrue(
                in_array(
                    'JahHub\FertilizerBundle\Entity\EntityInterface',
                    class_implements($this->container->getParameter($classParameterKey))
                )
            );
        }
    }

    /**
     */
    public function testRepositoryConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
        );

        foreach ($entityNameList as $entityName) {
            $serviceId = sprintf(
                'jahhub_fertilizer.repository.%s',
                $entityName
            );
            $classParameterKey = sprintf(
                '%s.class',
                $serviceId
            );

            $this->assertContainerBuilderHasParameter($classParameterKey);

            $this->assertContainerBuilderHasService(
                $serviceId,
                $this->container->getParameter($classParameterKey)
            );
        }
    }

    /**
     */
    public function testManagerConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
        );

        foreach ($entityNameList as $entityName) {
            $serviceId = sprintf(
                'jahhub_fertilizer.repository.%s',
                $entityName
            );
            $classParameterKey = sprintf(
                '%s.class',
                $serviceId
            );
            $this->assertContainerBuilderHasParameter($classParameterKey);

            $this->assertContainerBuilderHasService(
                $serviceId,
                $this->container->getParameter($classParameterKey)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new JahHubFertilizerExtension(),
        );
    }
}
