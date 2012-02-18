<?php

/**
 * Skeleton subclass for representing a row from the 'sft_aplicaciones' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sun Oct 23 16:15:17 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.sftGuardPlugin.lib.model
 */
class SftAplicacion extends BaseSftAplicacion
{
    /**
     * @var        SftCredencial
     */
    protected $aSftCredencial;

    public function getIdAplicacion()
    {
        return $this->getId();
    }

    public function __toString()
    {
        return self::getNombre();
    }

    public function hasAppFiles()
    {
        if ($this->getEsSymfonite())
        {
            $fController = $this->getCodigo();
            if (file_exists(sfConfig::get('sf_apps_dir') . '/' . $fController))
                return true;
            else
                return false;
        }
        else
            return true;
    }

    /**
     * Get the associated SftCredencial object
     *
     * @param      PropelPDO Optional Connection object.
     * @return     SftCredencial The associated SftCredencial object.
     * @throws     PropelException
     */
    public function getSftCredencial(PropelPDO $con = null)
    {
        if ($this->aSftCredencial === null && ($this->id_credencial !== null))
        {
            $this->aSftCredencial = SftCredencialPeer::retrieveByPk($this->id_credencial);
            /* The following can be used additionally to
              guarantee the related object contains a reference
              to this object.  This level of coupling may, however, be
              undesirable since it could result in an only partially populated collection
              in the referenced object.
              $this->aSftCredencial->addSftAplicacions($this);
             */
        }
        return $this->aSftCredencial;
    }

    public function delete(PropelPDO $con = null)
    {
        $this->setIdCredencial(null);
        $this->save();
        
        $c = new Criteria();
        $c->add(SftCredencialPeer::ID_APLICACION, $this->getId());

        SftCredencialPeer::doDelete($c);
        parent::delete($con);
    }

}

// SftAplicacion