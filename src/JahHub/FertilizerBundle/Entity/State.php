<?php
namespace JahHub\FertilizerBundle\Entity;

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
        $idList = array();
        foreach ($this->weekList as $week) {
            $idList[] = $week->getId();
        }

        return $idList;
    }
}
