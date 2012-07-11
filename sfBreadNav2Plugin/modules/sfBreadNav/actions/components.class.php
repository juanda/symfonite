<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of components
 *
 * @author mdep0071
 */
class sfBreadNavComponents extends sfComponents {

    public function executeCompMenu() {
        $aplicacion = SftAplicacionPeer::dameAplicacionConClave(sfConfig::get('app_clave'));
        $codigoAplicacion = $aplicacion->getCodigo();
        $c = new Criteria();
        $c->add(sfBreadNavApplicationPeer::APPLICATION, $codigoAplicacion);
        $aplicacionMenu = sfBreadNavApplicationPeer::doSelectOne($c);
        
        //si la aplicacion tiene un menu asociado recorremos el arbol
        if(!empty($aplicacionMenu)){
            $idNodo = $aplicacionMenu->getId();
            $root = BasesfBreadNavNestedSetPeer::retrieveRoot($idNodo);
            $arrayMenu = array();
            foreach ($root->getChildren() as $hijo)
                UtilidadesMenu::recorrerNodosMenu($hijo, 0, $arrayMenu);
            $this->arrayMenu = $arrayMenu;
        }
    }

}

?>
