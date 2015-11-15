<?php
namespace JahHub\FertilizerBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class WeekType
 */
class WeekType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('data_class', 'JahHub\FertilizerBundle\Entity\Week');
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'fertilizer_week';
    }
}
