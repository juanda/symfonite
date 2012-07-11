<?php

/**
 * Simple SQL authentication source
 *
 * This class is an example authentication source which authenticates an user
 * against a SQL database.
 *
 * @package simpleSAMLphp
 * @version $Id$
 */
class sspmod_sftauth_Auth_Source_SFT extends sspmod_core_Auth_UserPassBase
{


    /**
     * The DSN we should connect to.
     */
    private $dsn;


    /**
     * The username we should connect to the database with.
     */
    private $username;


    /**
     * The password we should connect to the database with.
     */
    private $password;


    /**
     * Constructor for this authentication source.
     *
     * @param array $info  Information about this authentication source.
     * @param array $config  Configuration.
     */
    public function __construct($info, $config)
    {
        assert('is_array($info)');
        assert('is_array($config)');

        /* Call the parent constructor first, as required by the interface. */
        parent::__construct($info, $config);

        /* Make sure that all required parameters are present. */
        foreach (array('dsn', 'username', 'password') as $param)
        {
            if (!array_key_exists($param, $config))
            {
                throw new Exception('Missing required attribute \'' . $param .
                        '\' for authentication source ' . $this->authId);
            }

            if (!is_string($config[$param]))
            {
                throw new Exception('Expected parameter \'' . $param .
                        '\' for authentication source ' . $this->authId .
                        ' to be a string. Instead it was: ' .
                        var_export($config[$param], TRUE));
            }
        }

        $this->dsn = $config['dsn'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }


    /**
     * Create a database connection.
     *
     * @return PDO  The database connection.
     */
    private function connect()
    {
        try
        {
            $db = new PDO($this->dsn, $this->username, $this->password);
        } catch (PDOException $e)
        {
            throw new Exception('sftauth:' . $this->authId . ': - Failed to connect to \'' .
                    $this->dsn . '\': '. $e->getMessage());
        }

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $driver = explode(':', $this->dsn, 2);
        $driver = strtolower($driver[0]);

        /* Driver specific initialization. */
        switch ($driver)
        {
            case 'mysql':
            /* Use UTF-8. */
                $db->exec("SET NAMES 'utf8'");
                break;
            case 'pgsql':
            /* Use UTF-8. */
                $db->exec("SET NAMES 'UTF8'");
                break;
        }

        return $db;
    }


    /**
     * Attempt to log in using the given username and password.
     *
     * On a successful login, this function should return the users attributes. On failure,
     * it should throw an exception. If the error was caused by the user entering the wrong
     * username or password, a SimpleSAML_Error_Error('WRONGUSERPASS') should be thrown.
     *
     * Note that both the username and the password are UTF-8 encoded.
     *
     * @param string $username  The username the user wrote.
     * @param string $password  The password the user wrote.
     * @return array  Associative array with the users attributes.
     */
    protected function login($username, $password)
    {
        assert('is_string($username)');
        assert('is_string($password)');

        $db = $this->connect();

        $query = 'SELECT sfgu.*, u.id as id_usuario FROM sf_guard_user as sfgu, sft_usuarios as u
                         where sfgu.username = :username and sfgu.id=u.id_sfuser';

        $usuario = $this -> query($db, $query,array('username' => $username) );

        // Si no se ha obtenido uno y solo un usuario, entonces
        // hay un error en la autentificación
        if(count($usuario) != 1)
        {
            SimpleSAML_Logger::error('sftauth:' . $this->authId .
                    ': No rows in result set. Probably wrong username.');
            throw new SimpleSAML_Error_Error('WRONGUSERPASS');
        }

        // Estraemos los datos necesarios para comprobar el password
        $salt       = $usuario[0]['salt'];
        $algorithm  = $usuario[0]['algorithm'];
        $pass       = $usuario[0]['password'];
        $uid        = $usuario[0]['username'];
        $id_sfuser  = $usuario[0]['id'];
        $id_usuario = $usuario[0]['id_usuario'];

        if (!is_callable($algorithm))
        {
            throw new Exception('sftauth:' . $this->authId .
                    ': - '.$algorithm.' is not a callable function: ');
        }

        if($pass != call_user_func_array($algorithm, array($salt.$password)))
        {
            SimpleSAML_Logger::error('sftauth:' . $this->authId .
                    ': Wrong password.');
            throw new SimpleSAML_Error_Error('WRONGUSERPASS');
        }

        // Ahora recopilamos todos los atributos:
        $attributes = array();

        $attributes['uid'][] = $uid;
        $attributes['id_sfuser'][] = $id_sfuser;

        /* Extract attributes. We allow the resultset to consist of multiple rows. Attributes
		 * which are present in more than one row will become multivalued. NULL values and
		 * duplicate values will be skipped. All values will be converted to strings.
        */
        /////////////////////////
        // ATRIBUTOS PERSONALES//
        /////////////////////////
        $query = "SELECT p.*,u.* from sft_personas as p, sft_usuarios as u
                  WHERE u.id = :id_usuario and u.id_persona=p.id";

        $persona = $this -> query($db, $query, array('id_usuario' => $id_usuario));

        if(!is_null($persona[0]['nombre']) && $persona[0]['nombre'] != '')    $attributes['cn'][] = $persona[0]['nombre'];
        if(!is_null($persona[0]['apellido1']) && $persona[0]['apellido1'] != '')
        {
            $attributes['schacSn1'][] = $persona[0]['apellido1'];
            $attributes['sn'][] = $persona[0]['apellido1'];
        }

        if(!is_null($persona[0]['apellido2']) && $persona[0]['apellido2'] !='')
            $attributes['schacSn2'][] = $persona[0]['apellido2'];
        if(!is_null($persona[0]['alias']) && $persona[0]['alias'] != '')
            $attributes['eduPersonNickname'][] = $persona[0]['alias'];
        if(!is_null($persona[0]['sexo']) && $persona[0]['sexo'] != '')
            $attributes['schacGender'][] = $persona[0]['sexo'];
        if(!is_null($persona[0]['fechanacimiento']) && $persona[0]['fechanacimiento'] != '')
            $attributes['schacDateOfBirth'][] = $persona[0]['fechanacimiento'];

        ////////////////////////////
        //PERMISOS EN APLICACIONES//
        ////////////////////////////

        $query = "SELECT c.*, ap.codigo
                  FROM sft_credenciales  as c, sft_perfil_credencial as pc, sft_accesos as a, sft_aplicaciones as ap
                  WHERE a.id_usuario = :id_usuario
                  AND a.id_perfil = pc.id_perfil
                  AND pc.id_credencial=c.id
                  AND c.id_aplicacion=ap.id
                  ORDER by c.nombre";

        $credenciales = $this -> query($db, $query, array('id_usuario' => $id_usuario));

        foreach($credenciales as $credencial)
        {
            $attributes['eduPersonEntitlement'][] = $credencial['codigo'].':'.$credencial['nombre'];
        }


        ///////////
        //ÁMBITOS//
        ///////////

        $query = "SELECT a.codigo as cod_amb, p.codigo as cod_per,
                 at.nombre as tipo_amb, ac.id_perfil as id_perfil
                 FROM sft_ambitos AS a, sft_ambitostipos as at,
                 sft_acceso_ambito AS aa, sft_accesos AS ac, sft_periodos as p
                 WHERE ac.id_usuario = :id_usuario
                 AND ac.id = aa.id_acceso
                 AND aa.id_ambito = a.id
                 AND a.id_ambitotipo = at.id
                 AND a.id_periodo = p.id
                 AND a.estado ='ACTIVO'
                 AND (aa.fechacaducidad IS NULL OR aa.fechacaducidad > '".date('Y-m-d')."')
";

        $ambitos = $this -> query($db, $query, array('id_usuario' => $id_usuario));
        
        $attributes['cursos'][] = '';
        foreach($ambitos as $ambito)
        {
            $attributes[$ambito['tipo_amb']][] = $ambito['cod_amb'] .':'.$ambito['cod_per'].':'.$ambito['id_perfil'].':active';                        
        }

        ///////////////////////
        //ATRIBUTOS EXTRAEDAE//
        ///////////////////////
        $query = "SELECT ua.nombre, uav.valor FROM sft_usu_atributos AS ua, sft_usu_atributos_valores AS uav
                    WHERE uav.id_usuario = :id_usuario
                    AND uav.id_usu_atributo = ua.id
                    AND (uav.expira IS NULL OR uav.expira > '".date('Y-m-d')."')";


        $data = $this -> query($db, $query, array('id_usuario' => $id_usuario));


        foreach ($data as $row)
        {
            $attributes[$row['nombre']][] = $row['valor'];
        }

        SimpleSAML_Logger::info('sftauth:' . $this->authId . ': Attributes: ' .
                implode(',', array_keys($attributes)));

        return $attributes;
    }

    protected function query($db, $query, $fields)
    {
        try
        {
            $sth = $db->prepare($query);
        } catch (PDOException $e)
        {
            throw new Exception('sftauth:' . $this->authId .
                    ': - Failed to prepare query: ' . $e->getMessage());
        }

        try
        {
            $res = $sth->execute($fields);
        } catch (PDOException $e)
        {
            throw new Exception('sftauth:' . $this->authId .
                    ': - Failed to execute query: ' . $e->getMessage());
        }

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

}

?>