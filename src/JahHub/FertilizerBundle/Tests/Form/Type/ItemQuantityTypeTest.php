<?php
namespace JahHub\FertilizerBundle\Tests\Form\Type;

use JahHub\FertilizerBundle\Form\Type\ItemQuantityType;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ItemQuantityTypeTest
 */
class ItemQuantityTypeTest extends AbstractTypeTest
{
    /** @var ItemQuantityType */
    protected $type;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->setType(new ItemQuantityType());
    }

    /**
     */
    public function testGetName()
    {
        $this->assertSame(
            'fertilizer_item_quantity',
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
        $optionResolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\ItemQuantity')
            ->shouldBeCalledTimes(1);

        $this->getType()->configureOptions($optionResolver->reveal());
    }

    /**
     */
    public function testBuild()
    {
        /** @var FormBuilderInterface|ObjectProphecy $formBuilder */
        $formBuilder = $this->prophesize('Symfony\Component\Form\FormBuilderInterface');
        $formBuilder->add('quantity', 'number')
            ->willReturn($formBuilder->reveal())
            ->shouldBeCalledTimes(1);

        $formBuilder
            ->add(
                'item',
                'entity',
                array(
                    'class' => 'JahHubFertilizerBundle:Item',
                )
            )
            ->willReturn($formBuilder->reveal())
            ->shouldBeCalledTimes(1);

        $this->getType()->buildForm($formBuilder->reveal(), array());
    }
}
