<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dsg
 *
 * @author mdep0071
 */

    class OpcionMenuNavegacion {

    private $nivel;
    private $nombre;
    private $ruta;

    public function getNivel() {
        return $this->nivel;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRuta() {
        return $this->ruta;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRuta($ruta) {
        $this->ruta = $ruta;
    }
}
?>
