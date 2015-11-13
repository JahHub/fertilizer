<?php
namespace JahHub\FertilizerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JahHub\FertilizerBundle\Entity\EntityInterface;
use JahHub\FertilizerBundle\Exception\InvalidFormException;
use JahHub\FertilizerBundle\RestHandler\AbstractHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AbstractController
 */
abstract class AbstractController extends FOSRestController
{
    /**
     * @param int $id entity id
     *
     * @return View
     *
     * @throws NotFoundHttpException when entity not exist
     */
    protected function handleDelete($id)
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
     * @return EntityInterface
     */
    protected function handlePost($returnRouteName)
    {
        try {
            $entity = $this->getHandler()->post(
                $this->container->get('request')->request->all()
            );

            $routeOptions = array(
                'id' => $entity->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView(
                $returnRouteName,
                $routeOptions,
                Codes::HTTP_CREATED
            );
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * @param $id
     *
     * @return array (EntityInterface, statusCode)
     */
    protected function handlePut($returnRouteName, $id)
    {
        try {
            $handler = $this->getHandler();
            if (!($entity = $handler->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $entity = $handler->post(
                    $this->container->get('request')->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $entity = $handler->put(
                    $entity,
                    $this->container->get('request')->request->all()
                );
            }

            $routeOptions = array(
                'id' => $entity->getId(),
                '_format' => $this->container->get('request')->get('_format'),
            );

            return $this->routeRedirectView($returnRouteName, $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Fetch an entity or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return EntityInterface
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
