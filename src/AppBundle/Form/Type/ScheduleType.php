<?php
namespace AppBundle\Form\Type;

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
                'state_list',
                'collection',
                array(
                    'property_path' => 'stateList',
                    'type' => 'entity',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                        'class' => 'AppBundle:State',
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

        $resolver->setDefault('data_class', 'AppBundle\Entity\Schedule');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fertilizer_schedule';
    }
}
