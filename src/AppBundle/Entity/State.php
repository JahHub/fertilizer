<?php
namespace AppBundle\Entity;

/**
 * Class State
 */
class State implements EntityInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Week[] */
    private $weekList = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Week[]
     */
    public function getWeekList()
    {
        return $this->weekList;
    }

    /**
     * @param Week[] $weekList
     */
    public function setWeekList(array $weekList)
    {
        $this->weekList = $weekList;
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
    public function getWeekIdList()
    {
        // $this->getWeekList() could return a Doctrine\Common\Collections\Collection
        // To be dependant => use iteration
        $idList = array();
        foreach ($this->getWeekList() as $week) {
            $idList[] = $week->getId();
        }

        return $idList;
    }
}
