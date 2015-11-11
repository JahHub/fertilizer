<?php
namespace JahHub\FertilizerBundle\Exception;

use Symfony\Component\Form\FormInterface;

/**
 * Class InvalidFormException
 */
class InvalidFormException extends \RuntimeException
{
    /** @var null|FormInterface */
    protected $form;

    /**
     * @param string             $message
     * @param FormInterface|null $form
     */
    public function __construct($message, FormInterface $form = null)
    {
        parent::__construct($message);
        $this->form = $form;
    }

    /**
     * @return null|FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}
