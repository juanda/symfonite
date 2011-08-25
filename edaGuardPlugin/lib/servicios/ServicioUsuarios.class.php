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
 * ServicioUsuarios.class.php
 *
 * Definicion de la clase ServicioUsuarios que extiende
 * la clase base Servicio e implementa funciones (Servicio)
 * que devuelven información relativa a los usuarios registrados
 * en el sistema.
 * 
 * 
 * @fecha 06-04-2010
 * @version 1.0.0
 *
 * @package Servicio
 * 
 */


abstract class ServicioUsuarios extends Servicio
{
    /**
     * Devuelve información sobre un usuario determinado.
     * La interfaz uniforme de entrada acepta dos parámetros:
     *  
     * id     -> un identificativo del usuario
     * tipoId -> el tipo de identificativo [ username, alias, edaId ]
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no está registrado en el sistema
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               `- tipoId
     * @return $out
     *          |-status
     *          |
     *          `-usuario
     *            |-identificacion
     *            | |-alias
     *            | |-username
     *            | |-sfId
     *            | `-edaId
     *            | ...
     *
     * Ejemplo de uso de la función:
     *
     * <code>
     * <?php
     *
     * $in = array('id' => 5, 'tipoId' => 'edaId');
     *
     * $out = ServicioUsuarios::usuario($in);
     *
     * if($out['status'] != Servicio::OK)
     * {
     *      echo Servicio::mensajeError($out['status']);
     *      exit;
     * }
     *
     *
     * //Código que manipule $out
     *
     * </code>
     *
     */
    abstract public function usuario($in);


     /**
     * Devuelve informacion sobre los perfiles que tiene un usuario
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               |- tipoId
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-usuario
     */
    abstract public function perfilesDelUsuarioEnAplicacion($in);

    /**
     * Devuelve informacion sobre las credenciale que tiene un usuario
     * en una aplicación identificada por su clave.
     *
     *  Los estados de salida pueden ser:
     * -> BAD_REQUEST si la interfaz uniforme de entrada no es válida
     * -> NOT_FOUND   si el usuario no existe
     * -> OK          si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id
     *               |- tipoId
     *               `- clave_aplicacion
     * @return $out
     *          |-status
     *          |
     *          `-credenciales
     */
    abstract public function credencialesDelUsuarioEnAplicacion($in);

    /**
     * Devuelve información sobre la configuración personal de un usuario en
     * una aplicación determinada
     *
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST            si la interfaz uniforme de entrada no es válida
     * -> NO_CONTENT             si alguno de los parámetros de la configuración personal
     *                           no se han podido hallar
     * -> INTERNAL_SERVER_ERROR  si el servicio ha fallado debido a una incongruencia
     *                           de los datos.
     * -> OK                     si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id                 -> identificador del usuario
     *               |- tipoId             -> tipo de identificador
     *               `- clave_aplicacion   -> clave de la aplicación
     *
     * @return array $out
     *                |- status
     *                `- configuracion_personal
     *                   |- valida
     *                   |- mensaje
     *                   |- id_perfil
     *                   |- id_ambito
     *                   |- id_uo
     *                   |- id_periodo
     *                   `- cultura_pref
     */
    abstract public function configuracionPersonalEnAplicacion($in);


    /**
     * Devuelve información sobre las aplicaciones a las que puede acceder un
     * usuario
     *
     * Los estados de salida pueden ser:
     * -> BAD_REQUEST            si la interfaz uniforme de entrada no es válida
     * -> NO_CONTENT             si alguno de los parámetros de la configuración personal
     *                           no se han podido hallar
     * -> INTERNAL_SERVER_ERROR  si el servicio ha fallado debido a una incongruencia
     *                           de los datos.
     * -> OK                     si se han recuperdado los datos de un usuario
     *
     * @param array $in
     *               |- id                 -> identificador del usuario
     *               `- tipoId             -> tipo de identificador*
     *
     * @return array $out
     *                |- status
     *                `- aplicaciones
     *                   |- aplicacion[0]
     *                   |  |- id
     *                   |  |- nombre
     *                   |  |- url
     *                   |  |- url_svn
     *                   |  |- clave
     *                   |  `- id_credencial
     *                   |
     *                   | ...
     *                   `- aplicacion[N]
     *                      |- id
     *                      |- nombre
     *                      |- url
     *                      |- url_svn
     *                      |- clave
     *                      `- id_credencial
     *                   
     */
    abstract public function aplicacionesDelUsuario($in);

}

/**

Ejemplo de salida de la función usuario:
 * 
 *  Array
(
    [status] => 200
    [usuario] => Array
        (
            [identificacion] => Array
                (
                    [alias] => pi
                    [edaId] => 1
                    [username] => pi
                    [sfId] => 1
                )

            [activo] => 1
            [fecha_alta] => 2010-03-30 09:15:15
            [fecha_baja] => 2010-03-30
            [cultura_pref] => es_ES
            [tipo] => persona
            [nombre] => Francisco
            [apellido1] => Pi
            [apellido2] => Margall
            [tipo_doc_id] => DNI
            [doc_id] => 111111
            [pais_doc_id] => España
            [sexo] => V
            [fechanacimiento] => 1894-04-20
            [profesion] => Escritor, jurista
            [observaciones] =>
            [telefonos] => Array
                (
                    [0] => Array
                        (
                            [telefono] => Array
                                (
                                    [numero] => 888888888
                                    [tipo] => móvil
                                )

                        )

                    [1] => Array
                        (
                            [telefono] => Array
                                (
                                    [numero] => 222222222
                                    [tipo] => Trabajo
                                )

                        )

                )

            [emails] => Array
                (
                    [0] => Array
                        (
                            [email] => Array
                                (
                                    [direccion] => pi@kuku.es
                                    [predeterminado] => si
                                )

                        )

                    [1] => Array
                        (
                            [email] => Array
                                (
                                    [direccion] => pi_maragall@lala.com
                                    [predeterminado] => no
                                )

                        )

                )

            [direcciones] => Array
                (
                    [0] => Array
                        (
                            [direccion] => Array
                                (
                                    [tipo] => calle
                                    [tipo_via] => calle
                                    [domicilio] => la parra
                                    [numero] => 56
                                    [escalera] => 5
                                    [piso] => 9
                                    [letra] => A
                                    [municipio] => Carmona
                                    [provincia] => Sevilla
                                    [pais] => España
                                    [cp] => 41410
                                )

                        )

                    [1] => Array
                        (
                            [direccion] => Array
                                (
                                    [tipo] => calle
                                    [tipo_via] => paseo
                                    [domicilio] => san antón
                                    [numero] => 12
                                    [escalera] =>
                                    [piso] =>
                                    [letra] =>
                                    [municipio] => El Viso
                                    [provincia] => Sevilla
                                    [pais] => España
                                    [cp] => 41417
                                )

                        )

                )

        )

)

 */



