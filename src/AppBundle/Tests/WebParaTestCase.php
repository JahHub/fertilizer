<?php
namespace AppBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Class WebParaTestCase
 */
class WebParaTestCase extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $testToken = getenv('TEST_TOKEN');
        $this->environment = sprintf(
            'paratest_%s',
            $testToken ?: '0'
        );
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
