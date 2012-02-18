<?php

/**
 * Skeleton subclass for representing a row from the 'sft_ambitos' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sun Oct 23 10:50:46 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sftGuardPlugin.lib.model
 */
class SftAmbito extends BaseSftAmbito
{

    /**
     * Initializes internal state of SftAmbitos object.
     * @see        parent::__construct()
     */
    public function __construct()
    {
        // Make sure that parent constructor is always invoked, since that
        // is where any default values for this object are set.
        parent::__construct();
    }

    public function getIdAmbito()
    {
        return $this->getId();
    }

    public function __toString()
    {
        return self::getNombre();
    }

}

// SftAmbito