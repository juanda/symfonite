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
 * ServicioEstructuraOrganizativa.class.php
 *
 * Definicion de la clase ServicioEstructuraOrganizativa que extiende
 * la clase base Servicio e implementa funciones (Servicio)
 * que devuelven información sobrte aspectos organizativos del centro
 * (unidades organizativas, perfiles, credenciales)
 *
 *
 * @fecha 06-04-2010
 * @version 1.0.0
 *
 * @package Servicio
 *
 */

abstract class ServicioEstructuraOrganizativa extends Servicio
{
    /**
     * Devuelve información sobre un perfil determinado.
     * La interfaz uniforme de entrada acepta un parámetro:
     *
     * id     ->  identificativo del perfil
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el perfil no está registrado en el sistema
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               `- id
     *
     * @return $out
     *          |-status
     *          |
     *          `-perfil
     *
     * Ejemplo de salida:
     * Array
     *(
     *    [status] => 200
     *    [perfil] => Array
     *        (
     *            [nombre] => Super Administrador
     *            [descripcion] => Super Administrador
     *            [abreviatura] => SuperAdmin
     *            [uo] => Array
     *                (
     *                    [id] => 1
     *                    [nombre] => Unidad Organizativa de Administración
     *                )
     *
     *            [credenciales] => Array
     *                (
     *                    [0] => Array
     *                        (
     *                            [credencial] => Array
     *                                (
     *                                    [nombre] => credencial1
     *                                    [descripcion] => credencial1
     *                                    [aplicacion] => prueba
     *                                )
     *
     *                        )
     *
     *                    [1] => Array
     *                        (
     *                            [credencial] => Array
     *                                (
     *                                    [nombre] => credencial2
     *                                    [descripcion] => credencial2
     *                                    [aplicacion] => prueba
     *                                )
     *
     *                        )
     *
     *                )
     *
     *        )
     *
     *)
     *
     */
    abstract public function perfil($in);
 

    /**
     * Devuelve el nombre, la descripcion y el periodo al que pertenece
     * un ambito con un determinado id y un determinado nombre de ambito
     *
     * @param array $in
     *                |- id  el id del ambito en la tabla de ambito (esto no hay quien lo entienda)
     *                `- ambito el nombre del ambito
     * @return array $out
     *                |- status
     *                `- ambito
     *                   |- nombre
     *                   |- descripcion
     *                   |- fechaAlta
     *                   `- idPeriodo
     */

    abstract public function ambito($in);

    /**
     *
     * @param array $in
     *                `- id
     *
     * @return array $out
     *                |- status
     *                `- periodo
     *                   |- fecha_inicio
     *                   |- fecha_fin
     *                   |- descripcio
     *                   `- estado
     */
    abstract public function periodo($in);

    /**
     * Devuelve informacion sobre las credenciales que tiene un perfil
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-credenciales
     */
    abstract public function credencialesDelPerfilEnAplicacion($in);

    }
?>
