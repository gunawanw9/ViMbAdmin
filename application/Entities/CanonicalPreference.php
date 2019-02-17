<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * CanonicalPreference
 */
class CanonicalPreference
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var integer
     */
    private $ix;

    /**
     * @var string
     */
    private $op;

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $expire;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Entities\Canonical
     */
    private $Canonical;


    /**
     * Set attribute
     *
     * @param string $attribute
     * @return CanonicalPreference
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    
        return $this;
    }

    /**
     * Get attribute
     *
     * @return string 
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set ix
     *
     * @param integer $ix
     * @return CanonicalPreference
     */
    public function setIx($ix)
    {
        $this->ix = $ix;
    
        return $this;
    }

    /**
     * Get ix
     *
     * @return integer 
     */
    public function getIx()
    {
        return $this->ix;
    }

    /**
     * Set op
     *
     * @param string $op
     * @return CanonicalPreference
     */
    public function setOp($op)
    {
        $this->op = $op;
    
        return $this;
    }

    /**
     * Get op
     *
     * @return string 
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return CanonicalPreference
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set expire
     *
     * @param integer $expire
     * @return CanonicalPreference
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
    
        return $this;
    }

    /**
     * Get expire
     *
     * @return integer 
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Canonical
     *
     * @param \Entities\Canonical $canonical
     * @return CanoicalPreference
     */
    public function setCanonical(\Entities\Canonical $canonical = null)
    {
        $this->Canonical = $canonical;
    
        return $this;
    }

    /**
     * Get Canonical
     *
     * @return \Entities\Canonical
     */
    public function getCanonical()
    {
        return $this->Canonical;
    }
}
