<?php
namespace JahHub\FertilizerBundle\Entity;

/**
 * Class Week
 */
class Week implements EntityInterface
{
    /** @var int */
    private $id;

    /** @var int */
    private $number;

    /** @var State */
    private $state;

    /** @var ItemQuantity[] */
    private $itemQuantityList = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return ItemQuantity[]
     */
    public function getItemQuantityList()
    {
        return $this->itemQuantityList;
    }

    /**
     * @param ItemQuantity[] $itemQuantityList
     */
    public function setItemQuantityList($itemQuantityList)
    {
        $this->itemQuantityList = $itemQuantityList;
    }

    /**
     * @return int
     */
    public function getStateId()
    {
        return $this->getState()->getId();
    }

    /**
     * @return int[]
     */
    public function getItemQuantityIdList()
    {
        // $this->getItemQuantityList() could return a Doctrine\Common\Collections\Collection
        // To be dependant => use iteration
        $idList = array();
        foreach ($this->getItemQuantityList() as $itemQuantity) {
            $idList[] = $itemQuantity->getId();
        }

        return $idList;
    }
}
