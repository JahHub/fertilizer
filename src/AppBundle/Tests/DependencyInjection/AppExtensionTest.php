<?php

namespace AppBundle\Tests\DependencyInjection;

use AppBundle\DependencyInjection\AppExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class AppExtensionTest
 */
class AppExtensionTest extends AbstractExtensionTestCase
{
    /**
     */
    public function testEntityClassConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
            'state',
            'week',
            'item_quantity',
            'schedule',
        );
        $interface = 'AppBundle\Entity\EntityInterface';

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
                    '%s class should implements "%s"',
                    $entityName,
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
            'state',
            'week',
            'item_quantity',
            'schedule',
        );
        $interface = 'AppBundle\Repository\EntityRepositoryInterface';

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
                    '%s repository should implements "%s"',
                    $entityName,
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
            'state',
            'week',
            'item_quantity',
            'schedule',
        );

        $parentClass = 'AppBundle\Manager\ObjectManager';
        $classParameterKey = 'jahhub_fertilizer.manager.object.class';

        foreach ($entityNameList as $entityName) {
            $serviceId = sprintf(
                'jahhub_fertilizer.manager.%s',
                $entityName
            );

            $this->assertContainerBuilderHasService(
                $serviceId,
                $this->container->getParameter($classParameterKey)
            );

            $this->assertTrue(
                in_array(
                    $parentClass,
                    class_parents($this->container->getParameter($classParameterKey))
                ) || $parentClass == $this->container->getParameter($classParameterKey),
                sprintf(
                    '%s manager should extend "%s"',
                    $entityName,
                    $parentClass
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
            'state',
            'week',
            'item_quantity',
            'schedule',
        );

        $interface = 'AppBundle\Handler\RESTHandlerInterface';

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
                    '%s handler should implements "%s"',
                    $entityName,
                    $interface
                )
            );
        }
    }

    /**
     */
    public function testTypeConfiguration()
    {
        $this->load();

        $entityNameList = array(
            'item',
            'state',
            'week',
            'item_quantity',
            'schedule',
        );
        $parentClass = 'AppBundle\Form\Type\AbstractType';

        foreach ($entityNameList as $entityName) {
            $serviceId = sprintf(
                'jahhub_fertilizer.form.type.%s',
                $entityName
            );
            $classParameterKey = sprintf(
                '%s.class',
                $serviceId
            );
            $formTypeAlias= sprintf(
                'fertilizer_%s',
                $entityName
            );

            $this->assertContainerBuilderHasParameter($classParameterKey);

            $this->assertContainerBuilderHasService(
                $serviceId,
                $this->container->getParameter($classParameterKey)
            );

            $this->assertContainerBuilderHasServiceDefinitionWithTag(
                $serviceId,
                'form.type',
                array(
                    'alias' => $formTypeAlias,
                )
            );

            $this->assertTrue(
                in_array(
                    $parentClass,
                    class_parents($this->container->getParameter($classParameterKey))
                ) || $parentClass == $this->container->getParameter($classParameterKey),
                sprintf(
                    '%s form type should extend "%s"',
                    $entityName,
                    $parentClass
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new AppExtension(),
        );
    }
}
