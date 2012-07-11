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
        //eliminar acentos, diéresis, etc
        
        $normalizeChars = array( 
             'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C', 
             'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth', 
             'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 
             'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 
     
             'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c', 
             'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth', 
             'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 
             'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 
             
             'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y' 
         );

        $cadena = strtr($cadena,$normalizeChars);
        //Ahora eliminamos todos los caracteres no alfanuméricos \W = [^0-9a-zA-Z]
        $cadena = preg_replace('/\W/','',$cadena);

        //El trim ya lo haría el preg_replace, pero por si las moscas.
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