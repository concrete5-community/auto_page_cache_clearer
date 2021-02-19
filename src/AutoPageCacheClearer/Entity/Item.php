<?php

namespace A3020\AutoPageCacheClearer\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   name="AutoPageCacheClearerItems",
 * )
 */
class Item
{
    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $events = [];

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $sourcePages = [];

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $sourcePageTypes = [];

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $targetPages = [];

    /**
     * @ORM\Column(type="json_array", nullable=false)
     */
    protected $targetPageTypes = [];

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param string[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @return int[]
     */
    public function getSourcePages()
    {
        return array_map('intval', $this->sourcePages);
    }

    /**
     * @param int[] $sourcePages
     */
    public function setSourcePages($sourcePages)
    {
        $this->sourcePages = $sourcePages;
    }

    /**
     * @return int[]
     */
    public function getSourcePageTypes()
    {
        return array_map('intval', $this->sourcePageTypes);
    }

    /**
     * @param int[] $sourcePageTypes
     */
    public function setSourcePageTypes($sourcePageTypes)
    {
        $this->sourcePageTypes = $sourcePageTypes;
    }

    /**
     * @return int[]
     */
    public function getTargetPages()
    {
        return array_map('intval', $this->targetPages);
    }

    /**
     * @param int[] $targetPages
     */
    public function setTargetPages($targetPages)
    {
        $this->targetPages = $targetPages;
    }

    /**
     * @return int[]
     */
    public function getTargetPageTypes()
    {
        return array_map('intval', $this->targetPageTypes);
    }

    /**
     * @param int[] $targetPageTypes
     */
    public function setTargetPageTypes($targetPageTypes)
    {
        $this->targetPageTypes = $targetPageTypes;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns true if this entity is persisted in the DB.
     *
     * @return bool
     */
    public function exists()
    {
        return (bool) $this->getId();
    }
}
