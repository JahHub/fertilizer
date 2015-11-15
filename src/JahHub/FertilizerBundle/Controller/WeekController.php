<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use JahHub\FertilizerBundle\Entity\Week;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class WeekController
 */
class WeekController extends AbstractController
{
    /**
     * List Weeks by {page} and {limit}
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "List all weeks.",
     *   output = "array<JahHub\FertilizerBundle\Entity\Week>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Week"
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing weeks."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="{5-20}",
     *  default="5",
     *  description="How many weeks to return."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return Week[]
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getHandler()->all($paramFetcher->get('page'), $paramFetcher->get('limit'));
    }

    /**
     * Get a Week for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "JahHub\FertilizerBundle\Entity\Week",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when week is not found"
     *   },
     *   section = "Week"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id week id
     *
     * @return Week
     *
     * @throws NotFoundHttpException when week not exist
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * Delete a week
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when week is not found"
     *   },
     *   section = "Week"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id week id
     *
     * @return View
     *
     * @throws NotFoundHttpException when week not exist
     */
    public function deleteAction($id)
    {
        return $this->handleDelete($id);
    }

    /**
     * Creates a new week from the submitted data.
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new week",
     *   input = "JahHub\FertilizerBundle\Entity\Week",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Week"
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|View
     */
    public function postAction()
    {
        return $this->handlePost('api_1_week_get');
    }

    /**
     * Update existing week from the submitted data or create a new week
     *
     * @ApiDoc(
     *   description = "Update existing or create a new week",
     *   resource = true,
     *   input = "JahHub\FertilizerBundle\Entity\Week",
     *   statusCodes = {
     *     201 = "Returned when Week is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Week"
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
        return $this->handlePut('api_1_week_get', $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.week');
    }
}
