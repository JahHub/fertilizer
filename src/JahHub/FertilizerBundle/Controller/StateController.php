<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use JahHub\FertilizerBundle\Entity\State;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StateController
 */
class StateController extends AbstractController
{
    /**
     * List States by {page} and {limit}
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "List all states.",
     *   output = "array<JahHub\FertilizerBundle\Entity\State>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "State",
     *   views={"default", "StateEntity", "List"}
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing states."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="[5-9]|1[0-9]|20",
     *  default="5",
     *  description="How many states to return ([5-20])."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return State[]
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getHandler()->all($paramFetcher->get('page'), $paramFetcher->get('limit'));
    }

    /**
     * Get a State for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "JahHub\FertilizerBundle\Entity\State",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when state is not found"
     *   },
     *   section = "State",
     *   views={"default", "StateEntity", "Get"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id state id
     *
     * @return State
     *
     * @throws NotFoundHttpException when state not exist
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * Delete a state
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when state is not found"
     *   },
     *   section = "State",
     *   views={"default", "StateEntity", "Delete"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id state id
     *
     * @return View
     *
     * @throws NotFoundHttpException when state not exist
     */
    public function deleteAction($id)
    {
        return $this->handleDelete($id);
    }

    /**
     * Creates a new state from the submitted data.
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new state",
     *   input = "JahHub\FertilizerBundle\Entity\State",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "State",
     *   views={"default", "StateEntity", "Create"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|View
     */
    public function postAction()
    {
        return $this->handlePost('api_1_state_get');
    }

    /**
     * Update existing state from the submitted data or create a new state
     *
     * @ApiDoc(
     *   description = "Update existing or create a new state",
     *   resource = true,
     *   input = "JahHub\FertilizerBundle\Entity\State",
     *   statusCodes = {
     *     201 = "Returned when State is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "State",
     *   views={"default", "StateEntity", "Put"}
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
        return $this->handlePut('api_1_state_get', $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.state');
    }
}
