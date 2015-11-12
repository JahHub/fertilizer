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
 * Class AbstractController
 */
abstract class AbstractController extends FOSRestController
{
    /**
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

        return $this->getHandler()->all($page, $limit);
    }

    /**
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
        $handler = $this->getHandler();
        if (!($handler->exist($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        } else {
            $handler->delete($id);

            return $this->view(array(), Codes::HTTP_OK);
        }
    }

    /**
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        try {
            $state = $this->getHandler()->post(
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
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function putAction($id)
    {
        try {
            $handler = $this->getHandler();
            if (!($state = $handler->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $state = $handler->post(
                    $this->container->get('request')->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $state = $handler->put(
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
        if (!($entity = $this->getHandler()->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $entity;
    }

    /**
     * @return AbstractHandler
     */
    abstract protected function getHandler();
}
