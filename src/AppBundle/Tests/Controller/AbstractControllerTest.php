<?php
namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractControllerTest
 */
abstract class AbstractControllerTest extends WebTestCase
{
    const UNKNOWN_ID = 999999999999999999;

    /** @var Client */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
        //reset database
        $this->loadFixtures(array());
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     */
    public function assertStatusCode(Response $response, $statusCode)
    {
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            sprintf(
                'Status code should be %s, but %s given',
                $statusCode,
                $response->getStatusCode()
            )
        );

    }

    /**
     * @param Response $response
     * @param int      $statusCode
     * @param bool     $checkValidJson
     * @param string   $contentType
     */
    protected function assertJsonResponse(
        Response $response,
        $statusCode = 200,
        $checkValidJson = true,
        $contentType = 'application/json'
    ) {
        $this->assertStatusCode($response, $statusCode);
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            sprintf(
                'Headers does not contains "%s" content type: %s',
                $contentType,
                $response->headers
            )
        );
        if ($checkValidJson) {
            $decode = json_decode($response->getContent());
            $this->assertTrue(
                ($decode != null && $decode != false),
                'is response valid json: ['.$response->getContent().']'
            );
        }
    }

    /**
     * @param Response $response
     * @param string   $url
     */
    protected function assertIsRedirectionTo(Response $response, $url = null)
    {
        $this->assertSame(
            $response->headers->get('Location'),
            $url,
            sprintf(
                'Assert response is redirection to "%s", but got "%s"',
                $url,
                $response->headers->get('Location')
            )
        );
    }

    /**
     * @param Response $response
     * @param string   $url
     */
    protected function assertIsRedirectionToPartialUrl(Response $response, $url)
    {
        $this->assertContains(
            $url,
            $response->headers->get('Location'),
            sprintf(
                'Assert response is redirection to location that contains "%s", but got "%s"',
                $url,
                $response->headers->get('Location')
            )
        );
    }

    /**
     * @param string $url
     *
     * @return null|Response
     */
    protected function doGetRequest($url)
    {
        $this->getClient()->request(
            'GET',
            $url,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        return $this->getClient()->getResponse();
    }

    /**
     * @param string $url
     *
     * @return null|Response
     */
    protected function doHeadRequest($url)
    {
        $this->getClient()->request(
            'HEAD',
            $url,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        return $this->getClient()->getResponse();
    }

    /**
     * @param string $url
     *
     * @return null|Response
     */
    protected function doPatchRequest($url)
    {
        $this->getClient()->request(
            'PATCH',
            $url,
            array('ACCEPT' => 'application/json'),
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        return $this->getClient()->getResponse();
    }

    /**
     * @param string $url
     * @param mixed  $content
     *
     * @return null|Response
     */
    protected function doPostRequest($url, $content)
    {
        $this->getClient()->request(
            'POST',
            $url,
            array('ACCEPT' => 'application/json'),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $content
        );

        return $this->getClient()->getResponse();
    }

    /**
     * @param string $url
     * @param mixed  $content
     *
     * @return null|Response
     */
    protected function doPutRequest($url, $content)
    {
        $this->getClient()->request(
            'PUT',
            $url,
            array('ACCEPT' => 'application/json'),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $content
        );

        return $this->getClient()->getResponse();
    }

    /**
     * @param string $url
     * @param mixed  $content
     *
     * @return null|Response
     */
    protected function doDeleteRequest($url, $content = null)
    {
        $this->getClient()->request(
            'DELETE',
            $url,
            array('ACCEPT' => 'application/json'),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            $content
        );

        return $this->getClient()->getResponse();
    }
}
