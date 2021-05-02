<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait DateTrait
{

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $date = new \DateTime();
        // Conversion en UTC
        $date->setTimezone(new \DateTimeZone('UTC'));
        $this->created = $date;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->updated = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
}