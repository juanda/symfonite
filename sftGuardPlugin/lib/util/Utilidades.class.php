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

class Utilidades
{
    static public function generaClave($longitud)
    {
        $voc = array ('a','e','i','o','u');
        $con = array ('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','w','x','y','z');
        $numeros =  range(1,9);
        $numeros_aleatorios = array_rand($numeros, 2);
        $password = '';
        $inicio  = mt_rand(0,1);

        for ($n=0;
        $n<$longitud;
        $n++)
        {
            if ($inicio==1)
            {
                $inicio=0;
                $password .= $con[mt_rand(0,count($con)-1)];
            }
            $password .= $voc[mt_rand(0,count($voc)-1)];
            $password .= $con[mt_rand(0,count($con)-1)];
        }

        $password = substr($password,0,$longitud-2);
        $password = $password.$numeros[$numeros_aleatorios[0]].$numeros[$numeros_aleatorios[1]];

        return $password;
    }

    static public function limpiarCadena($cadena)
    {
        $cadena = strtolower($cadena);
        $b     = array("á","é","í","ó","ú","ä","ë","ï","ö","ü","à","è","ì","ò","ù","ñ"," ",",",".",";",":","¡","!","¿","?",'"');
        $c     = array("a","e","i","o","u","a","e","i","o","u","a","e","i","o","u","n","","","","","","","","","",'');
        $cadena = str_replace($b,$c,$cadena);
        return trim($cadena);

    }

    /**
     * Esta función comprueba si existe una sesión activa con el token que se le
     * ha pasado por el argumento. En caso afirmativo devuelve el objeto sfGuardUser
     * que corresponde a la sesión. En caso negativo devuelve false
     *
     * @param <type> $token
     * @return <type>
     */
    static public function dameUsuarioConSesionActiva($token, $id_aplicacion)
    {
        if($token != '')
        {
            $c = new Criteria();
            $c -> add(SftAplicacionSesionPeer::ID_APLICACION, $id_aplicacion);
            $c -> add(SftAplicacionSesionPeer::TOKEN, $token);

            $aplicacion_sesion = SftAplicacionSesionPeer::doSelect($c);
            $sesionborrada = false;
            if(count($aplicacion_sesion) == 1)
            {
                $expira = $aplicacion_sesion[0] -> getExpira();

                $expiraTime = strtotime($expira);

                $entiempo = (($expiraTime - time()) > 0)? true: false;

                if($entiempo)
                {
                    $usuario = $aplicacion_sesion[0] -> getSftUsuario();
                    $aplicacion_sesion[0] -> delete();
                    $sesionborrada = true;

                    $sfUser = sfGuardUserPeer::retrieveByPK($usuario -> getIdSfuser());

                    return $sfUser;
                }
            }

            if(!$sesionborrada && count($aplicacion_sesion) > 0)
            {
                $aplicacion_sesion[0] -> delete();
            }

            return false;
        }

        return false;
    }

    static public function isSfBreadNavMenu()
    {
        $c = new Criteria();

        $c -> add (SftAplicacionPeer::CLAVE, sfConfig::get('app_clave'));
        $c -> addJoin(SftAplicacionPeer::SF_APP, sfBreadNavApplicationPeer::APPLICATION);

        $count = sfBreadNavApplicationPeer::doCount($c);

        if($count == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    static public function getNumDaysInBetween($start, $end)
    {
// Vars
        $day = 86400; // Day in seconds
        $format = 'Y-m-d'; // Output format (see PHP date funciton)
        $sTime = strtotime($start); // Start as time
        $eTime = strtotime($end); // End as time
        $numDays = round(($eTime - $sTime) / $day) + 1;

        return $numDays;
    }

}