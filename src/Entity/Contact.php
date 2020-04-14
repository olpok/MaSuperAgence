<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank 
     * @Assert\Length(
     *      min = 2, max = 100)
     * @var string|null
     */
    private $firstname;

    /**
     * @Assert\NotBlank 
     * @Assert\Length(
     *      min = 2, max = 100)
     * @var string|null
     */
    private $lastname;

    /**
     * @Assert\NotBlank 
     * @Assert\Regex(
     *   pattern= "/^[0-9]{10}/"
     * )
     * @var string|null
     */
    private $phone;

     /**
     * @Assert\NotBlank 
     * @Assert\Email
     * @var string|null
     */
    private $email;

     /**
     * @Assert\NotBlank 
     * @Assert\Length(
     *      min = 10)
     * @var string|null
     */
    private $message;

    /**
     * @var Property|null
     */
    private $property;

    /**
     * Get min = 2, max = 100)
     *
     * @return  string|null
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set min = 2, max = 100)
     *
     * @param  string|null  $firstname  min = 2, max = 100)
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get min = 2, max = 100)
     *
     * @return  string|null
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set min = 2, max = 100)
     *
     * @param  string|null  $lastname  min = 2, max = 100)
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get )
     *
     * @return  string|null
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set )
     *
     * @param  string|null  $phone  )
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get min = 10)
     *
     * @return  string|null
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set min = 10)
     *
     * @param  string|null  $message  min = 10)
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of property
     *
     * @return  Property|null
     */ 
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set the value of property
     *
     * @param  Property|null  $property
     *
     * @return  self
     */ 
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }
}