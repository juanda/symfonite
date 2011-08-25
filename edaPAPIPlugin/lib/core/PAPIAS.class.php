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
 * This class implements the needed services to build the PAPI assertion from
 * the PAPI request string and the attributes collected by the connector.
 *
 * It also implements a chain of filter to be applied before the assertion is
 * going to be builded. The chain of filters can be set throuht the config file
 * app.yml. // TODO The way to set an implement the chain of filter isn't
 * implemented yet.
 */
class PAPIAS
{

    protected $attributes = array();
    protected $sfUser;
    protected $assertion = '';
    protected $theURL = '';
    protected $theRef = '';

    /**
     * This constructor parses the PAPI request string (which has been previously
     * copied into the session, that is added as attributes of symfony sfUser class)
     * and build the parameters:
     * -> $theURL
     * -> theRef
     *
     * which are used in the assertion building proccess.
     *
     * This class has been designed with the chain filter design pattern in mind,
     * so most of the methods return the own object. This strategy allows to use
     * an PAPIAS class as follow:
     *
     * $papiasobject -> setAttributes($a) -> applyFilters() -> ...
     *
     *
     * @param sfUser $sfUser
     */
    public function __construct($sfUser)
    {
        if (!$sfUser instanceof sfUser)
        {
            throw new Exception('the argument of the constructor is not a sfUser object ');
        }

        $this->sfUser = $sfUser;
        if (!$sfUser->hasAttribute('ACTION', 'PAPIREQUEST') && !$sfUser->hasAttribute('ATTREQ', 'PAPIREQUEST'))
        {
            PAPIASLog::error("Unknown request (1). Use the PAPI 1.0 protocol");
        }
        if ($sfUser->hasAttribute('ACTION', 'PAPIREQUEST') &&
                ($sfUser->hasAttribute('ACTION', 'PAPIREQUEST') != "CHECK" ||
                !$sfUser->hasAttribute('DATA', 'PAPIREQUEST') || !$sfUser->hasAttribute('URL', 'PAPIREQUEST')))
        {
            PAPIASLog::error("Unknown request (2). Use the PAPI 1.0 protocol");
        }
        if ($sfUser->hasAttribute('ATTREQ', 'PAPIREQUEST') && (!$sfUser->hasAttribute('PAPIPOAREF', 'PAPIREQUEST')
                || !$sfUser->hasAttribute('PAPIPOAURL', 'PAPIREQUEST')))
        {
            PAPIASLog::error("Unknown request (3). Use the PAPI 1.0 protocol");
        }
        if ($sfUser->hasAttribute('ACTION', 'PAPIREQUEST'))
        {
            $this->theURL = $sfUser->getAttribute('URL', null, 'PAPIREQUEST');
            $this->theRef = $sfUser->getAttribute('DATA', null, 'PAPIREQUEST');
        } else
        {
            $this->theURL = $sfUser->getAttribute('PAPIPOAURL', null, 'PAPIREQUEST');
            $this->theRef = $sfUser->getAttribute('PAPIPOAREF', null, 'PAPIREQUEST');
        }
    }

    /**
     * This method allow to set the attributes retrieved by the connector. The
     * $attributes array must be normalized as follow:
     *
     * It must be an associative array which keys are the attributes name and
     * wich values can be scalars with the attributes values or arrays of values
     * if the attribute is multi-valued. For example:
     *
     * $attributes = array(
     * 'attr1' => val1,
     * 'attr2' => array(val21,val22,val23),
     * );
     * 
     * @param array $attributes
     * @return PAPIAS
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Build the assertion string wich will be encrypted an send afterword. Such
     * assertion is set as an object attribute.
     *
     * The assertion string is composed by pairs attribute_name=attribute_values
     * separated by commas, and must be ended with AS identifier: 'uid@as_id'
     *
     * When the attributes are multi-valued, they are expresed like this:
     *
     * attribute_name=attribute_value1|attribute_value1|...|attribute_valueN
     *
     * @return PAPIAS
     */
    public function buildAssertion()
    {
        // check that uid attribute is present
        if (!isset($this->attributes['uid']))
        {
            throw new Exception('user identifier parameter "uid" is missing');
        }

        $assertion = '';

        // Add attribute to assertion
        $k = 0;
        foreach ($this->attributes as $key => $value)
        {
            $assertion .= ( 0 == $k) ? '' : ',';
            if (is_array($value))
            {
                $i = 0;
                $lastElemI = count($value) - 1;
                foreach ($value as $value2)
                {
                    $assertion .= ( $i == 0) ? $key . '=' . $value2 : $value2;
                    $assertion .= ( $lastElemI != $i) ? '|' : '';
                    $i++;
                    $k++;
                }
            } else
            {
                $assertion .= $key . '=' . $value;
                $k++;
            }
        }
        // Add assertion identifier
        $assertion .= ( 0 == $k) ? '' : ',';
        $assertion .= $this->attributes['uid'] . '@' . sfConfig::get('app_eda_papi_plugin_as_id', 'example_AS');
        $this->assertion = $assertion;
//        echo '<pre>';
//        print_r($this->attributes);
//        echo $assertion;
//        echo '</pre>';//
//        exit;
        return $this;
    }

    /**
     * Add some time information to the assertion, encrypt this data with the
     * private key, and build the correct url to which the data will be redirected.
     *
     * @return string
     */
    public function buildRedirection()
    {
        $fp = fopen(sfConfig::get('app_eda_papi_plugin_as_pkey_file'), 'r');
        if (!$fp)
        {
            throw new Exception('private key file is missing');
        }

        $asId = sfConfig::get('app_eda_papi_plugin_as_id', 'example_AS');
        $pKey = fread($fp, filesize(sfConfig::get('app_eda_papi_plugin_as_pkey_file')));
        $now = time();
        $ttl = sfConfig::get('app_eda_papi_plugin_as_ttl', 3600);
        $ext = $now + $ttl;
        $reply = $this->assertion . ":" . $ext . ":" . $now . ":" . $this->theRef;
        $safe = PAPIASCrypto::openssl_encrypt($reply, $pKey, 1024);

        if (strpos($this->theURL, "?"))
        {
            $redirectTo = $this->theURL . "&";
        } else
        {
            $redirectTo = $this->theURL . "?";
        }
        if ($this->sfUser->hasAttribute('ACTION', 'PAPIREQUEST'))
        {
            $redirectTo .= "ACTION=CHECKED" . "&" . "DATA=" . urlencode($safe);
            PAPIASLog::doLog("GPoA response to " . $this->theURL . ": " . $reply);
        } else
        {
            $redirectTo .= "AS=" . $asId . "&ACTION=CHECKED" . "&" . "DATA=" . urlencode($safe);
            PAPIASLog::doLog("AS response to " . $this->theURL . ": " . $reply);
        }

        return $redirectTo;
    }

    /**
     * Apply to the attributes retrieved by the connector a set of filters which
     * have been set and sequenced in the app.yml config file.
     * @return PAPIAS
     */
    public function applyFilters()
    {
        $filters = sfConfig::get('app_eda_papi_plugin_filters_sequence');
                                
        if (!(is_array($filters) && count($filters) > 0))
        {
            return $this;
        }

        foreach($filters as $filter)
        {            
            $className = $filter['class_name'];
            if(!class_exists($className))
            {
                throw new Exception('The filter  "'.$className. '" does not exists');
            }

            $configuration = $filter['configuration'];
            $this -> attributes = call_user_func(array($className ,'execute'), 
                    $this -> attributes, $configuration);
        }        
        return $this;
    }

}
