<?php
namespace JahHub\FertilizerBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ScheduleType
 */
class ScheduleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add(
                'stateList',
                'collection',
                array(
                    'type' => 'entity',
                    'options' => array(
                        'class' => 'JahHubFertilizerBundle:State',
                        'empty_data' => false,
                        'invalid_message' => 'Invalid State',
                    ),
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\Schedule');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fertilizer_schedule';
    }
}
