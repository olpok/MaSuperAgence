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
     * @var integer|null
     */
    private $distance;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var string|null
     */
    private $address;


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


    /**
     * @return  float|null
     */ 
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param  float|null  $lng
     * @return  self
     */ 
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return  float|null
     */ 
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param  float|null  $lat
     * @return PropertySearch
     */ 
    public function setLat(?float $lat) : PropertySearch
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return  integer|null
     */ 
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param  integer|null  $distance
     * @return  self
     */ 
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }


    /**
     * @return  string|null
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param  string|null  $address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }
}