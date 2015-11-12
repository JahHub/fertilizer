<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use JahHub\FertilizerBundle\Entity\Item;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use JahHub\FertilizerBundle\RestHandler\AbstractHandler;
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
     *   section = "Item"
     * )
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        parent::listAction($paramFetcher);
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
     *   section = "Item"
     * )
     *
     * @param int $id item id
     *
     * @return Item
     *
     * @throws NotFoundHttpException when item not exist
     */
    public function getAction($id)
    {
        parent::getAction($id);
    }

    /**
     * Delete an item
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when item is not found"
     *   },
     *   section = "Item"
     * )
     *
     * @param int $id item id
     *
     * @return Item
     *
     * @throws NotFoundHttpException when item not exist
     */
    public function deleteAction($id)
    {
        parent::deleteAction($id);
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
     *   section = "Item"
     * )
     *
     * @return array|\FOS\RestBundle\View\View
     */
    public function postAction()
    {
        return parent::postAction();
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
     *   section = "Item"
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
        return $this->container->get('jahhub_fertilizer.handler.item');
    }
}
