<?php
namespace JahHub\FertilizerBundle\Tests\DependencyInjection;

use JahHub\FertilizerBundle\DependencyInjection\Configuration;
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
