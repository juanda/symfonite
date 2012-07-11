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

class EmbedI18n
{
    static public function aniadeTraducciones($form)
    {
        $culturas = SftCulturaPeer::doSelect(new Criteria);

        $tCulturas = array();
        foreach ($culturas as $c)
        {
            $tCulturas[] = $c -> getNombre();
        }

        $form -> embedI18n($tCulturas);

        foreach ($culturas as $c)
        {
           $form->getWidgetSchema()->setLabel($c -> getNombre(), $c -> getDescripcion());
        }
    }
    
    static public function aniadeTraduccionesElegidas($form)
    {
        $tCulturasElegidas = sfConfig::get('app_configuracion_culturas');

        $c = new Criteria();
        $c->add(SftCulturaPeer::NOMBRE, $tCulturasElegidas, CRITERIA::IN);
        $culturas = SftCulturaPeer::doSelect($c);

        $tCulturas = array();
        foreach ($culturas as $c)
        {
            $tCulturas[] = $c -> getNombre();
        }

        $form -> embedI18n($tCulturas);

        foreach ($culturas as $c)
        {
           $form->getWidgetSchema()->setLabel($c -> getNombre(), $c -> getDescripcion());
        }
    }
}
