<?php

/**
 * Skeleton subclass for representing a row from the 'sft_perfiles_i18n' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sun Oct 23 16:15:22 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sftGuardPlugin.lib.model
 */
class SftPerfilI18n extends BaseSftPerfilI18n
{

    /**
     * Initializes internal state of SftPerfilI18n object.
     * @see        parent::__construct()
     */
    public function __construct()
    {
        // Make sure that parent constructor is always invoked, since that
        // is where any default values for this object are set.
        parent::__construct();
    }

    public function getIdPerfil()
    {
        return $this->getId();
    }

}

// SftPerfilI18n
