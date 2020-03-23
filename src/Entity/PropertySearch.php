<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch{

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10,max=400)
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $preferences;

        public function __construct()
    {
        $this->preferences= new ArrayCollection();
    }

    /**
     * @return integer|null
     */
        public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param integer $maxPrice
     * @return self
     */
        public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return integer|null
     */
        public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param integer $minSurface
     * @return self
     */
        public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
        public function getPreferences(): ArrayCollection
    {
        return $this->preferences;
    }

    /**
     * @param ArrayCollection $preferences
     * @return void
     */
        public function setPreferences(ArrayCollection $preferences): void
    {
        $this->preferences = $preferences;
    }

}