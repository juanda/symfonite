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
 * EdaAmbitos filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class AmbitosModuloFormFilter extends BaseFormFilterPropel
{
    public function setup()
    {
        $this->setWidgets(array(
                'nombre'          => new sfWidgetFormInput(),


        ));

        $this->setValidators(array(
                'nombre'          => new sfValidatorString(),



        ));

        $this->widgetSchema->setNameFormat('eda_ambitos_filters[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        parent::setup();
    }

    protected function addNombreColumnCriteria(Criteria $criteria, $field, $values)
    {       
        $criteria->add(EdaAmbitosI18nPeer::NOMBRE, "%".$values."%", Criteria::LIKE);
        $criteria->add(EdaAmbitosI18nPeer::ID_CULTURA, sfContext::getInstance() -> getUser() -> getCulture());
        $criteria->addJoin(EdaAmbitosI18nPeer::ID, EdaAmbitosPeer::ID);
    }


    public function getModelName()
    {
        return 'EdaAmbitos';
    }

    public function getFields()
    {
        return array(
                'nombre'                     => 'String',
        );
    }
}

