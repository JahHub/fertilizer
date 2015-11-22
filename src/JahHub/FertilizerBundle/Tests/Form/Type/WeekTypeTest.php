<?php
namespace JahHub\FertilizerBundle\Tests\Form\Type;

use JahHub\FertilizerBundle\Form\Type\WeekType;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class WeekTypeTest
 */
class WeekTypeTest extends AbstractTypeTest
{

    /** @var WeekType */
    protected $type;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->setType(new WeekType());
    }

    /**
     */
    public function testBuild()
    {
        /** @var FormBuilderInterface|ObjectProphecy $formBuilder */
        $formBuilder = $this->prophesize('Symfony\Component\Form\FormBuilderInterface');
        $formBuilder
            ->add(
                'state',
                'entity',
                array(
                    'class' => 'JahHubFertilizerBundle:State',
                    'empty_data' => false,
                    'invalid_message' => 'Invalid State',
                )
            )
            ->shouldBeCalledTimes(1);

        $this->getType()->buildForm($formBuilder->reveal(), array());
    }

    /**
     */
    public function testGetName()
    {
        $this->assertSame(
            'fertilizer_week',
            $this->getType()->getName()
        );
    }

    /**
     */
    public function testDefault()
    {
        /** @var OptionsResolver|ObjectProphecy $optionResolver */
        $optionResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->prophesizeDefault($optionResolver);
        $optionResolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\Week')
            ->shouldBeCalledTimes(1);

        $this->getType()->configureOptions($optionResolver->reveal());
    }
}
