<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use JahHub\FertilizerBundle\Entity\Item;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\QueryParam;

/**
 * Class ItemController
 */
class ItemController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "List all items.",
     *   output = "array<JahHub\FertilizerBundle\Entity\Item>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Offset from which to start listing item."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="[5-20]",
     *  default="5",
     *  description="How many item to return."
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
        $offset = $page > 1 ? $page - 1 : 1;

        return $this->container->get('jahhub_fertilizer.handler.item')->all($limit, $offset);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Item for a given id",
     *   output = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item is not found"
     *   }
     * )
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id item id
     *
     * @return Item
     *
     * @throws NotFoundHttpException when item not exist
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Delete an item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item is not found"
     *   }
     * )
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id item id
     *
     * @return Item
     *
     * @throws NotFoundHttpException when item not exist
     */
    public function deleteAction($id)
    {
        if (!($this->container->get('jahhub_fertilizer.handler.item')->exist($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        } else {
            $this->container->get('jahhub_fertilizer.handler.item')->delete($id);

            return $this->view(array(), Codes::HTTP_OK);
        }
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new item from the submitted data.",
     *   input = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        try {
            $item = $this->container->get('jahhub_fertilizer.handler.item')->post(
                $this->container->get('request')->request->all()
            );

            $routeOptions = array(
                'id' => $item->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView(
                'api_1_item_get',
                $routeOptions,
                Codes::HTTP_CREATED
            );
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update existing item from the submitted data or create a new item at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     201 = "Returned when Item is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
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
            if (!($item = $this->container->get('jahhub_fertilizer.handler.item')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $item = $this->container->get('jahhub_fertilizer.handler.item')->post(
                    $this->container->get('request')->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $item = $this->container->get('jahhub_fertilizer.handler.item')->put(
                    $item,
                    $this->container->get('request')->request->all()
                );
            }

            $routeOptions = array(
                'id' => $item->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView('api_1_item_get', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Fetch an item or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return Item
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($entity = $this->container->get('jahhub_fertilizer.handler.item')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $entity;
    }
}
