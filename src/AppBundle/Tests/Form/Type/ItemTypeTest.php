<?php
namespace AppBundle\Tests\Form\Type;

use AppBundle\Form\Type\ItemType;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ItemTypeTest
 */
class ItemTypeTest extends AbstractTypeTest
{

    /** @var ItemType */
    protected $type;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->setType(new ItemType());
    }

    /**
     */
    public function testGetName()
    {
        $this->assertSame(
            'fertilizer_item',
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
        $optionResolver->setDefault('data_class', 'AppBundle\Entity\Item')
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
            ->shouldBeCalledTimes(1);

        $this->getType()->buildForm($formBuilder->reveal(), array());
    }
}
