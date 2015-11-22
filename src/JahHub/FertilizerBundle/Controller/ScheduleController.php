<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use JahHub\FertilizerBundle\Entity\Schedule;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ScheduleController
 */
class ScheduleController extends AbstractController
{
    /**
     * List Schedules by {page} and {limit}
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "List all schedules.",
     *   output = "array<JahHub\FertilizerBundle\Entity\Schedule>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Schedule"
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing schedules."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="{5-20}",
     *  default="5",
     *  description="How many schedules to return."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return Schedule[]
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getHandler()->all($paramFetcher->get('page'), $paramFetcher->get('limit'));
    }

    /**
     * Get a Schedule for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "JahHub\FertilizerBundle\Entity\Schedule",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when schedule is not found"
     *   },
     *   section = "Schedule"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id schedule id
     *
     * @return Schedule
     *
     * @throws NotFoundHttpException when schedule not exist
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * Delete a schedule
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when schedule is not found"
     *   },
     *   section = "Schedule"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id schedule id
     *
     * @return View
     *
     * @throws NotFoundHttpException when schedule not exist
     */
    public function deleteAction($id)
    {
        return $this->handleDelete($id);
    }

    /**
     * Creates a new schedule from the submitted data.
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new schedule",
     *   input = "JahHub\FertilizerBundle\Entity\Schedule",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Schedule"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|View
     */
    public function postAction()
    {
        return $this->handlePost('api_1_schedule_get');
    }

    /**
     * Update existing schedule from the submitted data or create a new schedule
     *
     * @ApiDoc(
     *   description = "Update existing or create a new schedule",
     *   resource = true,
     *   input = "JahHub\FertilizerBundle\Entity\Schedule",
     *   statusCodes = {
     *     201 = "Returned when Schedule is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Schedule"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function putAction($id)
    {
        return $this->handlePut('api_1_schedule_get', $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.schedule');
    }
}
