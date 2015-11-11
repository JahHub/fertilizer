<?php
namespace JahHub\FertilizerBundle\Tests\RestHandler;

use JahHub\FertilizerBundle\Exception\InvalidFormException;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Form\FormInterface;

/**
 * Class InvalidFormExceptionTest
 */
class InvalidFormExceptionTest extends \PHPUnit_Framework_TestCase
{

    /** @var InvalidFormException */
    private $exception;

    /** @var FormInterface|ObjectProphecy */
    private $form;

    /** @var string */
    private $message;

    /**
     * @{inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->message = 'INVALID_FORM';

        $this->form = $this->prophesize('Symfony\Component\Form\FormInterface');
        $this->exception = new InvalidFormException(
            $this->message,
            $this->form->reveal()
        );
    }

    /**
     */
    public function testGetForm()
    {
        $this->assertSame(
            $this->form->reveal(),
            $this->exception->getForm()
        );
    }
}
