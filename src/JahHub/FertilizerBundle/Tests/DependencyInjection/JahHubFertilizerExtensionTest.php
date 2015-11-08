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
        $interface = 'JahHub\FertilizerBundle\Entity\EntityInterface';

        foreach ($entityNameList as $entityName) {
            $classParameterKey = sprintf(
                'jahhub_fertilizer.entity.%s.class',
                $entityName
            );
            $this->assertContainerBuilderHasParameter($classParameterKey);

            $this->assertTrue(
                in_array(
                    $interface,
                    class_implements($this->container->getParameter($classParameterKey))
                ),
                sprintf(
                    'Should implments "%s"',
                    $interface
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
        $interface = 'JahHub\FertilizerBundle\Repository\EntityRepositoryInterface';

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

            $this->assertTrue(
                in_array(
                    $interface,
                    class_implements($this->container->getParameter($classParameterKey))
                ),
                sprintf(
                    'Should implments "%s"',
                    $interface
                )
            );
        }
    }

    /**
     */
    public function testHandlerConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
        );

        $interface = 'JahHub\FertilizerBundle\RestHandler\RESTHandlerInterface';

        foreach ($entityNameList as $entityName) {
            $serviceId = sprintf(
                'jahhub_fertilizer.handler.%s',
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

            $this->assertTrue(
                in_array(
                    $interface,
                    class_implements($this->container->getParameter($classParameterKey))
                ),
                sprintf(
                    'Should implments "%s"',
                    $interface
                )
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
