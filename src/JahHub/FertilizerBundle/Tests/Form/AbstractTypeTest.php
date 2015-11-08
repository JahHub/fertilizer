<?php
namespace JahHub\FertilizerBundle\Tests\Form;

use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractTypeTest
 */
class AbstractTypeTest extends TypeTestCase
{

    /** @var AbstractTypeMock */
    private $type;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->type = new AbstractTypeMock();
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
