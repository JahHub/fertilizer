<?php
namespace JahHub\FertilizerBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * Class WeekControllerTest
 */
class WeekControllerTest extends AbstractControllerTest
{
    /**
     */
    public function testJsonListAction()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);
        // limit should be overrided to 5
        $param = array(
            'page' => 1,
            'limit' => 2,
        );
        $route =  $this->getUrl('api_1_week_list', $param);
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
                'state' => 1,
                'item_quantity_list' => array(
                    1,
                    2,
                    3,
                ),
            ),
            array(
                'id' => 2,
                'state' => 2,
                'item_quantity_list' => array(
                    4,
                    5,
                    6,
                ),
            ),
            array(
                'id' => 3,
                'state' => 2,
                'item_quantity_list' => array(),
            ),
        );

        $this->assertSame(
            $expected,
            $decoded,
            'Should contains the 5 first weeks'
        );
    }

    /**
     */
    public function testJsonGetAction()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);
        $id = 1;
        $route =  $this->getUrl('api_1_week_get', array('id' => $id));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $expected = array(
            'id' => $id,
            'item_quantity_list' => array(
                1,
                2,
                3,
            ),
            'state' => 1,
        );
        $this->assertEquals(
            $expected,
            $decoded
        );
    }

    /**
     */
    public function testJsonHead()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_week_get', array('id' => 1));
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_OK);
    }

    /**
     */
    public function testJsonHeadWithUnknownWeek()
    {
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadWeekData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_week_get', array('id' => self::UNKNOWN_ID));
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonGetActionWithUnknownId()
    {
        $route =  $this->getUrl('api_1_week_get', array('id' => self::UNKNOWN_ID));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonPostAction()
    {
        $route =  $this->getUrl('api_1_week_post');
        $fixtures = array(
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadStateData',
        );
        $this->loadFixtures($fixtures);
        $param = array(
            'state' => 1,
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
     */
    public function testJsonPostActionWithBadParameters()
    {
        $route =  $this->getUrl('api_1_week_post');
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
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_week_put', array('id' => $id));
        $param = array(
            'state' => 1,
        );
        $jsonParam = json_encode($param);

        $response = $this->doPutRequest($route, $jsonParam);

        $this->assertStatusCode($response, $httpCode);
        if ($assertFullRedirection) {
            $url = $this->getUrl('api_1_week_put', array('id' => $id), true);
            $this->assertIsRedirectionTo($response, $url);
        } else {
            $url = str_replace(
                'ITEM_ID',
                '',
                $this->getUrl('api_1_week_get', array('id' => 'ITEM_ID'), true)
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
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_week_put', array('id' => 1));
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
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemData',
            'JahHub\FertilizerBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_week_delete', array('id' => $id));
        $response = $this->doDeleteRequest($route);

        $this->assertStatusCode($response, $httpCode);
    }

    /**
     * @return array
     */
    public function getTestJsonPutActionData()
    {
        return array(
            'Should modify week' => array(
                1,
                Codes::HTTP_NO_CONTENT,
                true,
            ),
            'Should create week' => array(
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
            'Delete existing week' => array(
                1,
                Codes::HTTP_OK,
            ),
            'Delete not existing week' => array(
                self::UNKNOWN_ID,
                Codes::HTTP_NOT_FOUND,
            ),
        );
    }
}
