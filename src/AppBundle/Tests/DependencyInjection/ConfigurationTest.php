<?php
namespace AppBundle\Tests\DependencyInjection;

use AppBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

/**
 * Class ConfigurationTest
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     */
    public function testConfiguration()
    {
        $this->assertConfigurationIsValid(
            array()
        );
    }
}
