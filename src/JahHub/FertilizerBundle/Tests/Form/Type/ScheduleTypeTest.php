<?php
namespace JahHub\FertilizerBundle\Tests\Form\Type;

use JahHub\FertilizerBundle\Form\Type\ScheduleType;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ScheduleTypeTest
 */
class ScheduleTypeTest extends AbstractTypeTest
{

    /** @var ScheduleType */
    protected $type;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->setType(new ScheduleType());
    }

    /**
     */
    public function testGetName()
    {
        $this->assertSame(
            'fertilizer_schedule',
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
        $optionResolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\Schedule')
            ->shouldBeCalledTimes(1);

        $this->getType()->configureOptions($optionResolver->reveal());
    }

    /**
     */
    public function testBuild()
    {
        /** @var FormBuilderInterface|ObjectProphecy $formBuilder */
        $formBuilder = $this->prophesize('Symfony\Component\Form\FormBuilderInterface');
        $formBuilder->add('name', 'text')
            ->willReturn($formBuilder->reveal())
            ->shouldBeCalledTimes(1);

        $formBuilder
            ->add(
                'state_list',
                'collection',
                array(
                    'property_path' => 'stateList',
                    'type' => 'entity',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                        'class' => 'JahHubFertilizerBundle:State',
                        'empty_data' => false,
                        'invalid_message' => 'Invalid State',
                    ),
                )
            )
            ->willReturn($formBuilder->reveal())
            ->shouldBeCalledTimes(1);

        $this->getType()->buildForm($formBuilder->reveal(), array());
    }
}
