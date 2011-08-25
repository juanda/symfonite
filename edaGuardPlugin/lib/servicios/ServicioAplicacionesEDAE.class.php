<?php
/*
* Copyright 2010 Instituto de Tecnologías Educativas - Ministerio de Educación de España
*
* Licencia con arreglo a la EUPL, Versión 1.1 exclusivamente
* (la «Licencia»);
* Solo podrá usarse esta obra si se respeta la Licencia.
* Puede obtenerse una copia de la Licencia en:
*
* http://ec.europa.eu/idabc/eupl5
* 
* y también en:

* http://ec.europa.eu/idabc/en/document/7774.html
*
* Salvo cuando lo exija la legislación aplicable o se acuerde
* por escrito, el programa distribuido con arreglo a la
* Licencia se distribuye «TAL CUAL»,
* SIN GARANTÍAS NI CONDICIONES DE NINGÚN TIPO, ni expresas
* ni implícitas.
* Véase la Licencia en el idioma concreto que rige
* los permisos y limitaciones que establece la Licencia.
*/
?>
<?php

class ServicioAplicacionesEDAE extends ServicioAplicaciones
{
    public function autorizacion($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['clave']))
        {
            $out['status']  =  Servicio::BAD_REQUEST; //Bad Request
            return $out;
        }
        ///////////////////////////////////////////

        $out = array();
        $clave = $in['clave'];

        $c = new Criteria();
        $c -> add(EdaAplicacionesPeer::CLAVE, $clave);
        $oAplicacion = EdaAplicacionesPeer::doSelectOne($c);

        if(($oAplicacion instanceof EdaAplicaciones))
        {
            $out['status'] = Servicio::ACCEPTED; // Accepted
        }
        else
        {
            $out['status']  = Servicio::UNAUTHORIZED; // Unauthorized
        }

        return $out;
    }

    public function credenciales($in)
    {
        /////////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['clave']))
        {
            $out['status']  =  Servicio::BAD_REQUEST; //Bad Request
            return $out;
        }
        ///////////////////////////////////////////

        $out = array();
        $clave = $in['clave'];

        $c = new Criteria();

        $c -> add(EdaAplicacionesPeer::CLAVE, $clave);
        $c -> addJoin(EdaAplicacionesPeer::ID_CREDENCIAL, EdaCredencialesPeer::ID);

        $credenciales = EdaCredencialesPeer::doSelect($c);

        $c -> clear();
        $c -> add(EdaAplicacionesPeer::CLAVE, $clave);
        $aplicacion = EdaAplicacionesPeer::doSelectOne($c);

        $i = 0;
        foreach ($credenciales as $c)
        {
            $out['credenciales'][$i]['nombre']      = $c -> getNombre();
            $out['credenciales'][$i]['descripcion'] = $c -> getDescripcion();
            $i++;
        }

        $out['credencial_de_acceso']['nombre']      = $aplicacion -> getEdaCredenciales() -> getNombre();
        $out['credencial_de_acceso']['descripcion'] = $aplicacion -> getEdaCredenciales() -> getDescripcion();

        $out['status'] = Servicio::OK;

        return $out;
    }
}
