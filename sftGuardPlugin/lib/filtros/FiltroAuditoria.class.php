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
 * Activando este filtro en las aplicaciones se puede llevar a cabo una
 * auditoria de las peticiones realizadas por los usuarios  y los parámetros
 * que se les pasa a las misma. Se pueden monitorizar todas las peticiones
 * o un subconjunto.
 *
 * Como activar el filtro.
 *
 * En el fichero apps/{aplicacion}/config/filters.yml:
 *
 * auditoria:
 * class: FiltroAuditoria
 * param:
 *   actions: ~    # auditar todas las acciones
 *   #actions: [ 'inicio/index', 'gespro_instalaciones/index' ] # auditar un subconjunto
 *
 */


class FiltroAuditoria extends sfFilter
{

    public function execute($filterChain)
    {
        $request = $this->getContext()->getRequest();

        $auditedActions = $this->getParameter('actions');
        $modAction = $request->getParameter('module').
                '/' . $request->getParameter('action');
        
        if (is_null($this->getParameter('actions')) ||
                in_array($modAction, $auditedActions))
        {
            $user = $this->getContext()->getUser();
            if ($this->isFirstCall())
            {
                $getParams = $this->parseArray($request->getParameterHolder()->getALl());

                if (strtoupper($request->getMethod()) == 'POST' ||
                        strtoupper($request->getMethod()) == 'PUT')
                {
                    $postParams = ' POST PARAMS :';
                    $params = $request->getPostParameters();
                    foreach ($params as $p)
                    {
                        $postParams .= $this->parseArray($p);
                    }
                }


                $logger = $this->getContext()->getLogger();
                $mensaje = $user->getAttribute('username', null, 'SftUser') . ' has requested: ' .
                        $getParams;
                $mensaje = (isset($postParams)) ? $mensaje . $postParams : $mensaje;
                $logger->info($mensaje);
            }
        }
        // Execute next filter
        $filterChain->execute();
    }

    private function parseArray($data)
    {
        return trim(implode(' ',
                        array_map(create_function('$key, $value', 'if(!is_array($value)) return $key."=".$value." | ";'),
                                array_keys($data), array_values($data))), ",");
    }

}
