<?php
namespace JahHub\FertilizerBundle\Tests\Form\Type;

use JahHub\FertilizerBundle\Form\Type\AbstractType;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractTypeTest
 */
abstract class AbstractTypeTest extends TypeTestCase
{

    /** @var AbstractType */
    private $type;

    /**
     * @return AbstractType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AbstractType $type
     */
    public function setType(AbstractType $type)
    {
        $this->type = $type;
    }

    /**
     */
    public function testDefault()
    {
        /** @var OptionsResolver|ObjectProphecy $optionResolver */
        $optionResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->prophesizeDefault($optionResolver);

        $this->type->configureOptions($optionResolver->reveal());
    }

    /**
     * @param ObjectProphecy $optionResolver
     */
    public function prophesizeDefault(ObjectProphecy $optionResolver)
    {
        $optionResolver->setDefault('csrf_protection', false)
            ->shouldBeCalledTimes(1);
    }
}
