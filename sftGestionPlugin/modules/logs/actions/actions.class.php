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

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 7634 2008-02-27 18:01:40Z fabien $
 */
class logsActions extends sfActions
{
	public function executeIndex(sfRequest $request)
	{
		$this->error=false;
		$this->lista_def = null;
		$this->lista_opciones = sfConfig::get('app_logs_aplicaciones');		
	}

	public function executeLista(sfRequest $request){
		//Inicializamos error.
		$this->error=false;
		
		//Inicializamos regExp.
		$regExp = "";
		
		//recogemos los distintos tipos de lgs.
		$this->lista_opciones = sfConfig::get('app_logs_aplicaciones');

		//Recogemos el UO del usuario
		$UO = $this->getUser()->getAttribute('idUnidadOrganizativa', null, 'SftUser');

		//Consultamos el directorio que guarda los logs.
		$dir = sfConfig::get('sf_log_dir');

		//Creamos la expresion regular para filtrar los ficheros
		//segun la opcion elegida.
		foreach ($this->lista_opciones as $elemento){
			if ($request->getParameter('logs')==$elemento['clave']){
				$regExp = "/".$elemento['nombre']."_".$UO."_.*/";
				$this->lista = $elemento['clave'];
				break;
			}
		}
		if ($regExp=="") $this->error = true;
		
		//Si se ha producido un error es porque se ha introducido un parametro mal.
		if (! $this->error){
			//Leemos el directorio donde se encuentran los logs.
			$dh  = opendir($dir);
			while (false !== ($filename = readdir($dh))) {
				if (!is_dir($filename))
				$files[] = $filename;
			}

			//Filtramos segun la expresion regular.
			$this->lista_def = preg_grep ($regExp, $files);
			rsort($this->lista_def);
		}
		$this->setTemplate('index');
	}

	public function executeVer(sfRequest $request){
		$this  -> setLayout('ventanaNueva');
		$fichero = sfConfig::get('sf_log_dir').'/'.$request->getParameter('nombre');
		$fop = fopen($fichero,'r');
		$this->contenido = fread($fop,filesize($fichero));
		fclose($fop);
	}

	public function executeDescargar(sfRequest $request){
		$nombreFichero = $request->getParameter('nombre');
		$fichero = sfConfig::get('sf_log_dir').'/'.$nombreFichero;

		$ctype = 'text/plain';
		
		$this ->setLayout(false);

		sfConfig::set('sf_web_debug', false);
		$response = $this -> getResponse();

		$response -> clearHttpHeaders();
		$response -> setHttpHeader('Pragma', 'public');
		$response -> setHttpHeader('Expires', '0');
		$response -> setHttpHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
		$response -> setHttpHeader('Cache-Control', 'private',false);
		$response -> setHttpHeader('Content-Type', $ctype,true);
		$response -> setHttpHeader('Content-Disposition', 'attachment; filename="'.basename($nombreFichero).'"');
		$response -> setHttpHeader('Content-Transfer-Encoding', 'binary');
		$response -> setHttpHeader('Content-Length',filesize($fichero));
		$response -> sendHttpHeaders();

		if(file_exists($fichero)){
			$response -> setContent(readfile($fichero));
			flush();
		}else{
			$response -> setContent('No se puede descargar '.
			$nombreFichero . '.Comuníquenlo al responsable de la aplicación en ecentro.') ;
		}

		$response->sendContent();

		return sfView::NONE;
	}


	public function executeBorrar(sfRequest $request){
		$fichero = sfConfig::get('sf_log_dir').'/'.$request->getParameter('nombre');
		unlink($fichero);
		$pp =
		$this->redirect('logs/Lista?logs='.$request->getParameter('lista'));
	}
}