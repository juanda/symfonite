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

class ServicioUsuariosCVE extends ServicioUsuarios
{
    public function usuario($in)
    {
        ///////////////////////////////////////////
        // comprobación de la interfaz de entrada//
        ///////////////////////////////////////////
        if(!isset($in['id']) || !isset($in['tipoId']))
        {
            $out['status'] = Servicio::BAD_REQUEST;
            return $out;
        }
        ///////////////////////////////////////////

        // Cuidado, aunque la variable se llama cveUsuario
        // Se trata de una Persona de CVE.
        // Le llamo usuario por similitud conceptual con EDAE
        $cveUsuario = self::dameCVEUsuario($in);

        if($cveUsuario instanceof Personas)
        {
            $usuario     = array();
            $telefonos   = array();
            $emails      = array();
            $direcciones = array();

            $c = new Criteria();
            $c -> add(sfGuardUserPeer::ID, $cveUsuario -> getIdSfuser());
            $sfUsuario = sfGuardUserPeer::doSelectOne($c);

            $usuario['identificacion']['alias']      = '';
            $usuario['identificacion']['edaId']      = $cveUsuario -> getId();
            $usuario['identificacion']['username']   = $sfUsuario  -> getUsername();
            $usuario['identificacion']['sfId']       = $sfUsuario  -> getId();

            $usuario['activo']       = 1;
            $usuario['fecha_alta']   = $cveUsuario -> getFechaAlta();
            $usuario['fecha_baja']   = '';
            $usuario['cultura_pref'] = $cveUsuario -> getConfpersonales() -> getIdiomaPref();



            $usuario['tipo']            = 'persona'; // En CVE no hay organismos, que es el otro tipo posible
            $usuario['nombre']          = $cveUsuario -> getNombre();
            $usuario['apellido1']       = $cveUsuario -> getApellido1();
            $usuario['apellido2']       = $cveUsuario -> getApellido2();
            $usuario['tipo_doc_id']     = '';
            $usuario['doc_id']          = $cveUsuario -> getDNI();
            $usuario['pais_doc_id']     = $cveUsuario -> getIdPaisnacionalidad();
            $usuario['sexo']            = $cveUsuario -> getSexo();
            $usuario['fechanacimiento'] = $cveUsuario -> getFechanacimiento();
            $usuario['profesion']       = $cveUsuario -> getProfesion();
            $usuario['observaciones']   = $cveUsuario -> getObservaciones();

            $usuario['telefonos'][0]['telefono']['numero'] = $cveUsuario -> getTelefono();
            $usuario['emails'][0]['email']['direccion']       = $cveUsuario -> getEmail();


            if($cveUsuario -> getDirecciones() instanceof Direcciones)
            {
                $usuario['direcciones'][0]['direccion']['tipo']      = '';
                $usuario['direcciones'][0]['direccion']['tipo_via']  = $cveUsuario -> getDirecciones() -> getTipovia();
                $usuario['direcciones'][0]['direccion']['domicilio'] = $cveUsuario -> getDirecciones() -> getDomicilio();
                $usuario['direcciones'][0]['direccion']['numero']    = $cveUsuario -> getDirecciones() -> getNumero();
                $usuario['direcciones'][0]['direccion']['escalera']  = $cveUsuario -> getDirecciones() -> getEscalera();
                $usuario['direcciones'][0]['direccion']['piso']      = $cveUsuario -> getDirecciones() -> getPiso();
                $usuario['direcciones'][0]['direccion']['letra']     = $cveUsuario -> getDirecciones() -> getLetra();
                $usuario['direcciones'][0]['direccion']['municipio'] = $cveUsuario -> getDirecciones() -> getMunicipio();
                $usuario['direcciones'][0]['direccion']['provincia'] = $cveUsuario -> getDirecciones() -> getProvincia();
                $usuario['direcciones'][0]['direccion']['pais']      = $cveUsuario -> getDirecciones() -> getPais();
                $usuario['direcciones'][0]['direccion']['cp']        = $cveUsuario -> getDirecciones() -> getCp();
            }

            $out['status']  = Servicio::OK ;
            $out['usuario'] = $usuario;
        }
        else
        {
            $out['status'] = Servicio::NOT_FOUND;
        }

        return $out;
    }
}
