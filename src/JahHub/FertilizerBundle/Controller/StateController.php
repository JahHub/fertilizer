<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use JahHub\FertilizerBundle\Entity\State;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use JahHub\FertilizerBundle\RestHandler\AbstractHandler;
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
     *   section = "State"
     * )
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return parent::listAction($paramFetcher);
    }

    /**
     * Get an State for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "JahHub\FertilizerBundle\Entity\State",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when state is not found"
     *   },
     *   section = "State"
     * )
     *
     * @param int $id state id
     *
     * @return State
     *
     * @throws NotFoundHttpException when state not exist
     */
    public function getAction($id)
    {
        return parent::getAction($id);
    }

    /**
     * Delete an state
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when state is not found"
     *   },
     *   section = "State"
     * )
     *
     * @param int $id state id
     *
     * @return State
     *
     * @throws NotFoundHttpException when state not exist
     */
    public function deleteAction($id)
    {
        parent::deleteAction($id);
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
     *   section = "State"
     * )
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        return parent::postAction();
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
     *   section = "State"
     * )
     *
     * @param int $id
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function putAction($id)
    {
        return parent::putAction($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.state');
    }
}
