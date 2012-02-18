<?php

class sfBreadNavApplication extends BasesfBreadNavApplication
{
    public function getSftAplicacion()
    {
        $c = new Criteria();
        
        $c->add(SftAplicacionPeer::CODIGO, $this->getApplication());
        
        $aplicacion = SftAplicacionPeer::doSelectOne($c);
        
        return $aplicacion;   
    }
}
