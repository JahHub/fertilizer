<?php
namespace JahHub\FertilizerBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * Class ItemControllerTest
 */
class ItemControllerTest extends AbstractControllerTest
{
    /**
     */
    public function testJsonGetAction()
    {
        $fixtures = array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData');
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_item_get', array('id' => 1));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['id']));
        $this->assertTrue(isset($decoded['name']));
    }

    /**
     */
    public function testJsonPostAction()
    {
        $route =  $this->getUrl('api_1_item_post');
        $param = array(
            'name' => 'name_1',
        );
        $jsonParam = json_encode($param);
        $response = $this->doPostRequest($route, $jsonParam);
        $this->assertSame(
            Codes::HTTP_CREATED,
            $response->getStatusCode(),
            'Entity not created'
        );
        $this->assertTrue($response->isRedirect());
    }

    /**
     * @dataProvider getTestJsonPostActionWithBadNameData
     * @param string $name
     */
    public function testJsonPostActionWithBadName($name)
    {
        $route =  $this->getUrl('api_1_item_post');
        $param = array(
            'name' => $name,
        );
        $jsonParam = json_encode($param);
        $response = $this->doPostRequest($route, $jsonParam);
        $this->assertJsonResponse($response, Codes::HTTP_BAD_REQUEST);
        $this->assertContains('NOT_NULL', $response->getContent());
        $expected = array(
            'code' => 400,
            'message' => 'Validation Failed',
            'errors' => array(
                'children' => array(
                    'name' => array(
                        'errors' => array(
                            'NOT_BLANK',
                            'NOT_NULL',
                        ),
                    ),
                ),
            ),
        );
        $this->assertSame(
            $expected,
            json_decode($response->getContent(), true)
        );
    }

    /**
     */
    public function testJsonPostActionWithBadParameters()
    {
        $route =  $this->getUrl('api_1_item_post');
        $param = '{"plip":"plop"}';
        $response = $this->doPostRequest($route, $param);
        $this->assertJsonResponse($response, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * @dataProvider getTestJsonPutActionData
     *
     * @param int  $id
     * @param int  $httpCode
     * @param bool $assertFullRedirection
     */
    public function testJsonPutAction($id, $httpCode, $assertFullRedirection)
    {
        $fixtures = array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData');
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_item_get', array('id' => $id));
        $param = array(
            'name' => 'custom_name',
        );
        $jsonParam = json_encode($param);

        $response = $this->doPutRequest($route, $jsonParam);

        $this->assertStatusCode($response, $httpCode);
        if ($assertFullRedirection) {
            $url = $this->getUrl('api_1_item_get', array('id' => $id), true);
            $this->assertIsRedirectionTo($response, $url);
        } else {
            $url = str_replace(
                'ITEM_ID',
                '',
                $this->getUrl('api_1_item_get', array('id' => 'ITEM_ID'), true)
            );
            $this->assertIsRedirectionToPartialUrl($response, $url);
        }
    }

    /**
     * @dataProvider getTestJsonDeleteActionData
     *
     * @param int $id
     * @param int $httpCode
     */
    public function testJsonDeleteAction($id, $httpCode)
    {
        $fixtures = array('JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData');
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_item_delete', array('id' => $id));
        $response = $this->doDeleteRequest($route);

        $this->assertStatusCode($response, $httpCode);
    }

    /**
     * @return array
     */
    public function getTestJsonPostActionWithBadNameData()
    {
        return array(
            'null' => array(null),
            'emtpty' => array(''),
        );
    }

    /**
     * @return array
     */
    public function getTestJsonPutActionData()
    {
        return array(
            'Should modify item' => array(
                1,
                Codes::HTTP_NO_CONTENT,
                true,
            ),
            'Should create item' => array(
                2,
                Codes::HTTP_CREATED,
                false,
            ),
        );
    }

    public function getTestJsonDeleteActionData()
    {
        return array(
            'Delete existing item' => array(
                1,
                Codes::HTTP_OK,
            ),
            'Delete not existing item' => array(
                999999999,
                Codes::HTTP_NOT_FOUND,
            ),
        );
    }
}
