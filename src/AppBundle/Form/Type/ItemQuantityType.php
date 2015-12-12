<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ItemQuantityType
 */
class ItemQuantityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', 'number')
            ->add(
                'item',
                'entity',
                array(
                    'class' => 'AppBundle:Item',
                    'empty_data' => false,
                    'invalid_message' => 'Invalid Item',
                )
            )
            ->add(
                'week',
                'entity',
                array(
                    'class' => 'AppBundle:Week',
                    'empty_data' => false,
                    'invalid_message' => 'Invalid Week',
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', 'AppBundle\Entity\ItemQuantity');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fertilizer_item_quantity';
    }
}
