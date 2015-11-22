<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Request\ParamFetcherInterface;
use JahHub\FertilizerBundle\Entity\Item;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ItemController
 */
class ItemController extends AbstractController
{
    /**
     * List Items by {page} and {limit}
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "List all items.",
     *   output = "array<JahHub\FertilizerBundle\Entity\Item>",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   },
     *   section = "Item",
     *   views={"default", "ItemEntity", "List"}
     * )
     *
     * @QueryParam(
     *  name="page",
     *  requirements="\d+",
     *  nullable=true,
     *  default="1",
     *  description="Page from which to start listing items."
     * )
     * @QueryParam(
     *  name="limit",
     *  requirements="{5-20}",
     *  default="5",
     *  description="How many items to return."
     * )
     *
     * @Route(requirements={"_format"="json|xml"}, path="")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return Item[]
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        return $this->getHandler()->all($paramFetcher->get('page'), $paramFetcher->get('limit'));
    }

    /**
     * Get an Item for a given id
     *
     * @ApiDoc(
     *   resource = true,
     *   output = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item is not found"
     *   },
     *   section = "Item",
     *   views={"default", "ItemEntity", "Get"}
     * )
     *
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
     * Delete an item
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item is not found"
     *   },
     *   section = "Item",
     *   views={"default", "ItemEntity", "Delete"}
     * )
     *
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
        return $this->handleDelete($id);
    }

    /**
     * Creates a new item from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new item",
     *   input = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Item",
     *   views={"default", "ItemEntity", "Create"}
     * )
     *
     * @Route(requirements={"_format"="json|xml"})
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        return $this->handlePost('api_1_item_get');
    }

    /**
     * Update existing item from the submitted data or create a new item
     *
     * @ApiDoc(
     *   description = "Update existing or create a new item",
     *   resource = true,
     *   input = "JahHub\FertilizerBundle\Entity\Item",
     *   statusCodes = {
     *     201 = "Returned when Item is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   },
     *   section = "Item",
     *   views={"default", "ItemEntity", "Put"}
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
        return $this->handlePut('api_1_item_get', $id);
    }

    /**
     * {@inheritdoc}
     */
    protected function getHandler()
    {
        return $this->container->get('jahhub_fertilizer.handler.item');
    }
}
