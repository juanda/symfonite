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
/**
 * ServicioAplicaciones.class.php
 *
 * Definicion de la clase ServicioAplicaciones que extiende
 * la clase base Servicio e implementa funciones (Servicio)
 * que devuelven información relativa a las aplicaciones registradas
 * en el sistema.
 * 
 * 
 * @fecha 06-04-2010
 * @version 1.0.0
 *
 * @package Servicio
 * 
 */


abstract class ServicioAplicaciones extends Servicio
{
    /**
     * Esta función se utiliza para comprobar si una aplicación está
     * registrada en el sistema, es decir, si está autorizada para
     * utilizar los Servicio. La aplicación que utilice este servicio
     * debe indicarle en la interfaz uniforme de entrada la clave que
     * le ha sido asignada por el sistema.
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST  Si la interfaz uniforme de entrada no es válida
     * -> ACCEPTED     Si la aplicación está autorizada
     * -> UNAUTHORIZED Si la aplicación no está autorizada
     *
     * @param array $in
     *               `- clave
     *
     *  @return array $out
     *                 `- status                    
     */
    abstract public function autorizacion($in);


    /**
     * Devuelve las credenciales de la aplicación.
     *
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST  Si la interfaz uniforme de entrada no es válida
     * -> ACCEPTED     Si la aplicación está autorizada
     * -> UNAUTHORIZED Si la aplicación no está autorizada
     *
     * @param array $in
     *               `- clave
     *
     *  @return array $out
     *                 |- status
     *                 |- credenciales
     *                 `- credencial_de_acceso
     */
    abstract public function credenciales($in);

}
