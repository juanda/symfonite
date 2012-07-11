<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilidadesMenu
 *
 * @author mdep0071
 */
class UtilidadesMenu {

    public static function recorrerNodosMenu($nodo, $profundidad, &$array) {
        if ($nodo->getNumberOfChildren() == 0) {
            $op = new OpcionMenuNavegacion();
            $op->setNivel($profundidad);
            $op->setNombre($nodo->getPage());
            $op->setRuta($nodo->getRoute());
            $array[] = $op;
        }
        else {
            $op = new OpcionMenuNavegacion();
            $op->setNivel($profundidad);
            $op->setNombre($nodo->getPage());
            $op->setRuta($nodo->getRoute());
            $array[] = $op;
            $profundidad++;
            $hijos = $nodo->getChildren();
            foreach ($hijos as $hijo) {
                self::recorrerNodosMenu($hijo, $profundidad, $array);
            }
        }
    }

}

?>
