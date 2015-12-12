<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ItemQuantity;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ItemQuantityController
 */
class ItemQuantityController extends AbstractController
{
    /**
     * List ItemQuantity entities by {page} and {limit}
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "List all ItemQuantity entities.",
     *   output = "array<AppBundle\Entity\ItemQuantity>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "ItemQuantity",
     *   views={"default", "ItemQuantityEntity", "List"}
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing ItemQuantity entities."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="[5-9]|1[0-9]|20",
     *  default="5",
     *  description="How many ItemQuantity entities to return ([5-20])."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return ItemQuantity[]
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getHandler()->all($paramFetcher->get('page'), $paramFetcher->get('limit'));
    }

    /**
     * Get an ItemQuantity for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "AppBundle\Entity\ItemQuantity",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item_quantity is not found"
     *   },
     *   section = "ItemQuantity",
     *   views={"default", "ItemQuantityEntity", "Get"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id item_quantity id
     *
     * @return ItemQuantity
     *
     * @throws NotFoundHttpException when item_quantity not exist
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * Delete an ItemQuantity
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item_quantity is not found"
     *   },
     *   section = "ItemQuantity",
     *   views={"default", "ItemQuantityEntity", "Delete"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @param int $id item_quantity id
     *
     * @return View
     *
     * @throws NotFoundHttpException when item_quantity not exist
     */
    public function deleteAction($id)
    {
        return $this->handleDelete($id);
    }

    /**
     * Creates a new item_quantity from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new ItemQuantity",
     *   input = "AppBundle\Entity\ItemQuantity",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "ItemQuantity",
     *   views={"default", "ItemQuantityEntity", "Create"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|View
     */
    public function postAction()
    {
        return $this->handlePost('api_1_item_quantity_get');
    }

    /**
     * Update existing ItemQuantity from the submitted data or create a new ItemQuantity
     *
     * @ApiDoc(
     *   description = "Update existing or create a new item_quantity",
     *   resource = true,
     *   input = "AppBundle\Entity\ItemQuantity",
     *   statusCodes = {
     *     201 = "Returned when ItemQuantity is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "ItemQuantity",
     *   views={"default", "ItemQuantityEntity", "Put"}
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
        return $this->handlePut('api_1_item_quantity_get', $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.item_quantity');
    }
}
