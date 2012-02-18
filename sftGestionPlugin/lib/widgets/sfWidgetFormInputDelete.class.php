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

class sfWidgetFormInputDelete extends sfWidgetFormInput {

	protected function configure($options = array(), $attributes = array()) {

		$this->addRequiredOption('url');

		$this->addRequiredOption('model_id');

		$this->addOption('confirm', null);

		$this->addOption('icon', null);

		parent::configure($options, $attributes);
	}

	public function render($name, $value = null, $attributes = array(), $errors = array()) {

		$ctx = sfContext::getInstance();

		$request = $ctx->getRequest();

		$controller = $ctx->getController();

		if (is_null($this->getOption('confirm'))) {

			$this->setOption('confirm', __('Are you sure you want to delete this item?'));

		}

		if (is_null($this->getOption('icon'))) {

			$this->setOption('icon', sprintf('http://%s%s/sfPropelPlugin/images/delete.png', $request->getHost(), $request->getRelativeUrlRoot()));

		} else {
			$this->setOption('icon', sprintf('http://%s%s/images/%s', $request->getHost(), $request->getRelativeUrlRoot(), $this->getOption('icon')));
		}

		$html = parent::render($name, $value, $attributes, $errors);

		$img = $this->renderTag('img', array('src' => $this->getOption('icon')));

		$link = '<a href="'.$controller->genUrl($this->getOption('url')).'?id='.$this->getOption('model_id').'" onclick="if (confirm(\''.$this->getOption('confirm').'\')) { return true; };return false;">'.$img.'</a>';

		$html .= $link;

		return $html;

	}

}