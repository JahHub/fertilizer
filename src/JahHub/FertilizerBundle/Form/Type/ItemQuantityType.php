<?php
namespace JahHub\FertilizerBundle\Form\Type;

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
                    'class' => 'JahHubFertilizerBundle:Item',
                    'empty_data' => false,
                    'invalid_message' => 'Invalid Item',
                )
            )
            ->add(
                'week',
                'entity',
                array(
                    'class' => 'JahHubFertilizerBundle:Week',
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

        $resolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\ItemQuantity');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fertilizer_item_quantity';
    }
}
