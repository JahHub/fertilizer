<?php
namespace JahHub\FertilizerBundle\Entity;

/**
 * Class ItemQuantity
 */
class ItemQuantity implements EntityInterface
{
    /** @var int */
    private $id;

    /** @var Item */
    private $item;

    /** @var Week */
    private $week;

    /** @var float in ml */
    private $quantity;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return Week
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param Week $week
     */
    public function setWeek(Week $week)
    {
        $this->week = $week;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->item->getId();
    }

    /**
     * @return int
     */
    public function getWeekId()
    {
        return $this->week->getId();
    }
}
