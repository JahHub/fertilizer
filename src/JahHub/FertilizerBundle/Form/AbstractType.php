<?php
namespace JahHub\FertilizerBundle\Form;

use Symfony\Component\Form\AbstractType as BaseAbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractType
 */
abstract class AbstractType extends BaseAbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('csrf_protection', false);
    }
}
