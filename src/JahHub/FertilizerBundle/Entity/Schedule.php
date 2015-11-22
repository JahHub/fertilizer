<?php
namespace JahHub\FertilizerBundle\Entity;

/**
 * Class Schedule
 */
class Schedule implements EntityInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var State[] */
    private $stateList = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return State
     */
    public function getStateList()
    {
        return $this->stateList;
    }

    /**
     * @param State[] $stateList
     */
    public function setStateList(array $stateList)
    {
        $this->stateList = $stateList;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int[]
     */
    public function getStateIdList()
    {
        // $this->getStateList() could return a Doctrine\Common\Collections\Collection
        // To be dependant => use iteration
        $idList = array();
        foreach ($this->getStateList() as $itemQuantity) {
            $idList[] = $itemQuantity->getId();
        }

        return $idList;
    }
}
