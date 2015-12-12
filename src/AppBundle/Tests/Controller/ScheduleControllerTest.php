<?php
namespace AppBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * Class ScheduleControllerTest
 */
class ScheduleControllerTest extends AbstractControllerTest
{
    /**
     */
    public function testJsonListAction()
    {
        $fixtures = array(
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);
        //limit should be overrided to 5
        $param = array(
            'page' => 1,
            'limit' => 2,
        );
        $route =  $this->getUrl('api_1_schedule_list', $param);
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
                'state_list' => array(
                    1,
                    2,
                ),
            ),
            array(
                'id' => 2,
                'name' => 'name_2',
                'state_list' => array(),
            ),
        );

        $this->assertSame(
            $expected,
            $decoded,
            'Should contains the 5 first Schedule entities'
        );
    }

    /**
     */
    public function testJsonGetAction()
    {
        $fixtures = array(
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);
        $id = 1;
        $route =  $this->getUrl('api_1_schedule_get', array('id' => $id));
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $decoded = json_decode($response->getContent(), true);
        $expected = array(
            'id' => $id,
            'name' => 'name_1',
            'state_list' => array(
                1,
                2,
            ),
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
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_schedule_get', array('id' => 1));
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_OK);
    }

    /**
     */
    public function testJsonHeadWithUnknownSchedule()
    {
        $fixtures = array(
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl(
            'api_1_schedule_get',
            array('id' => self::UNKNOWN_ID)
        );
        $response = $this->doHeadRequest($route);
        $this->assertStatusCode($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonGetActionWithUnknownId()
    {
        $route =  $this->getUrl(
            'api_1_schedule_get',
            array('id' => self::UNKNOWN_ID)
        );
        $response = $this->doGetRequest($route);
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }

    /**
     */
    public function testJsonPostAction()
    {
        $fixtures = array(
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
        );
        $this->loadFixtures($fixtures);
        $route =  $this->getUrl('api_1_schedule_post');
        $param = array(
            'name' => 'my_name',
            'state_list' => array(
                1,
            ),
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
        $route =  $this->getUrl('api_1_schedule_post');
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
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_schedule_put', array('id' => $id));
        $param = array(
            'name' => 'my_name',
            'state_list' => array(
                1,
                2,
            ),
        );
        $jsonParam = json_encode($param);

        $response = $this->doPutRequest($route, $jsonParam);

        $this->assertStatusCode($response, $httpCode);
        if ($assertFullRedirection) {
            $url = $this->getUrl('api_1_schedule_put', array('id' => $id), true);
            $this->assertIsRedirectionTo($response, $url);
        } else {
            $url = str_replace(
                'ITEM_ID',
                '',
                $this->getUrl('api_1_schedule_get', array('id' => 'ITEM_ID'), true)
            );
            $this->assertIsRedirectionToPartialUrl($response, $url);
        }
    }

    /**
     */
    public function testJsonPutActionWithBadParameters()
    {
        $fixtures = array(
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_schedule_put', array('id' => 1));
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
            'AppBundle\Tests\Fixtures\Entity\LoadItemData',
            'AppBundle\Tests\Fixtures\Entity\LoadStateData',
            'AppBundle\Tests\Fixtures\Entity\LoadWeekData',
            'AppBundle\Tests\Fixtures\Entity\LoadItemQuantityData',
            'AppBundle\Tests\Fixtures\Entity\LoadScheduleData',
        );
        $this->loadFixtures($fixtures);

        $route = $this->getUrl('api_1_schedule_delete', array('id' => $id));
        $response = $this->doDeleteRequest($route);

        $this->assertStatusCode($response, $httpCode);
    }

    /**
     * @return array
     */
    public function getTestJsonPutActionData()
    {
        return array(
            'Should modify Schedule' => array(
                1,
                Codes::HTTP_NO_CONTENT,
                true,
            ),
            'Should create Schedule' => array(
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
            'Delete existing Schedule' => array(
                1,
                Codes::HTTP_OK,
            ),
            'Delete not existing Schedule' => array(
                self::UNKNOWN_ID,
                Codes::HTTP_NOT_FOUND,
            ),
        );
    }
}
