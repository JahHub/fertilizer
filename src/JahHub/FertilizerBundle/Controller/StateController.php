<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use JahHub\FertilizerBundle\Entity\State;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StateController
 */
class StateController extends FOSRestController
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
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing states."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="{5-20}",
     *  default="5",
     *  description="How many states to return."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('limit');

        return $this->container->get('jahhub_fertilizer.handler.state')->all($page, $limit);
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
     * Delete an state
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when state is not found"
     *   },
     *   section = "State"
     * )
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id state id
     *
     * @return State
     *
     * @throws NotFoundHttpException when state not exist
     */
    public function deleteAction($id)
    {
        if (!($this->container->get('jahhub_fertilizer.handler.state')->exist($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        } else {
            $this->container->get('jahhub_fertilizer.handler.state')->delete($id);

            return $this->view(array(), Codes::HTTP_OK);
        }
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
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        try {
            $state = $this->container->get('jahhub_fertilizer.handler.state')->post(
                $this->container->get('request')->request->all()
            );

            $routeOptions = array(
                'id' => $state->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView(
                'api_1_state_get',
                $routeOptions,
                Codes::HTTP_CREATED
            );
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
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
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function putAction($id)
    {
        try {
            if (!($state = $this->container->get('jahhub_fertilizer.handler.state')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $state = $this->container->get('jahhub_fertilizer.handler.state')->post(
                    $this->container->get('request')->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $state = $this->container->get('jahhub_fertilizer.handler.state')->put(
                    $state,
                    $this->container->get('request')->request->all()
                );
            }

            $routeOptions = array(
                'id' => $state->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView('api_1_state_get', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Fetch an state or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return State
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($entity = $this->container->get('jahhub_fertilizer.handler.state')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $entity;
    }
}
