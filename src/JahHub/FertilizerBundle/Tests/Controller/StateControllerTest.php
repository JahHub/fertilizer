<?php
namespace JahHub\FertilizerBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * Class StateControllerTest
 */
class StateControllerTest extends AbstractControllerTest
{
    /**
     */
    public function testJsonListAction()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);
        // limit should be overrided to 5
        $param = array(
            'page' => 1,
            'limit' => 2,
        );
        $route =  $this->getUrl('api_1_state_list', $param);
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $this->assertTrue(
            is_array($decoded),
            'Should be an array'
        );
        $expected = array(
            array(
                'id' => 1,
                'name' => 'name_1',
            ),
            array(
                'id' => 2,
                'name' => 'name_2',
            ),
        );

        $this->assertSame(
            $expected,
            $decoded,
            'Should contains the 5 first states'
        );
    }

    /**
     */
    public function testJsonGetAction()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_state_get', array('id' => 1));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $this->assertTrue(isset($decoded['id']));
        $this->assertTrue(isset($decoded['name']));
    }

    /**
     */
    public function testJsonHead()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_state_get', array('id' => 1));
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_OK);
    }

    /**
     */
    public function testJsonHeadWithUnknownState()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_state_get', array('id' => self::UNKNOWN_ID));
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonGetActionWithUnknownId()
    {
        $route =  $this->getUrl('api_1_state_get', array('id' => self::UNKNOWN_ID));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonPostAction()
    {
        $route =  $this->getUrl('api_1_state_post');
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
        $route =  $this->getUrl('api_1_state_post');
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
        $route =  $this->getUrl('api_1_state_post');
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
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_state_put', array('id' => $id));
        $param = array(
            'name' => 'custom_name',
        );
        $jsonParam = json_encode($param);

        $response = $this->doPutRequest($route, $jsonParam);

        $this->assertStatusCode($response, $httpCode);
        if ($assertFullRedirection) {
            $url = $this->getUrl('api_1_state_put', array('id' => $id), true);
            $this->assertIsRedirectionTo($response, $url);
        } else {
            $url = str_replace(
                'ITEM_ID',
                '',
                $this->getUrl('api_1_state_get', array('id' => 'ITEM_ID'), true)
            );
            $this->assertIsRedirectionToPartialUrl($response, $url);
        }
    }

    /**
     */
    public function testJsonPutActionWithBadParameters()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_state_put', array('id' => 1));
        $param = array(
            'plip' => 'plop',
        );
        $jsonParam = json_encode($param);

        $response = $this->doPutRequest($route, $jsonParam);

        $this->assertJsonResponse($response, Codes::HTTP_BAD_REQUEST);
    }

    /**
     * @dataProvider getTestJsonDeleteActionData
     *
     * @param int $id
     * @param int $httpCode
     */
    public function testJsonDeleteAction($id, $httpCode)
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_state_delete', array('id' => $id));
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
            'empty' => array(''),
        );
    }

    /**
     * @return array
     */
    public function getTestJsonPutActionData()
    {
        return array(
            'Should modify state' => array(
                1,
                Codes::HTTP_NO_CONTENT,
                true,
            ),
            'Should create state' => array(
                self::UNKNOWN_ID,
                Codes::HTTP_CREATED,
                false,
            ),
        );
    }

    /**
     * @return array
     */
    public function getTestJsonDeleteActionData()
    {
        return array(
            'Delete existing state' => array(
                1,
                Codes::HTTP_OK,
            ),
            'Delete not existing state' => array(
                self::UNKNOWN_ID,
                Codes::HTTP_NOT_FOUND,
            ),
        );
    }
}
