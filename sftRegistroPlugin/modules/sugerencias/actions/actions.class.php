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

class sugerenciasActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->forward404Unless(sfConfig::get('app_sugerencias_enabled'));
        $this->formSugerencia = new RgtSugerenciaForm();

        if ($request->isMethod('post')) {
            $this->formSugerencia->bind($request->getParameter('rgt_sugerencia'));

            if ($this->formSugerencia->isValid()) {
                //print_r("Es valido ");        exit;
                $idUsuario = $this->getUser()->getAttribute('idUsuario', null, 'SftUser');
                $sugerencia = new RgtSugerencia();
                $sugerencia->setSugerencia($this->formSugerencia->getValue('sugerencia'));
                $sugerencia->setIdUsuario($idUsuario);
                $sugerencia->save();
                $this->redirect('@sugerencias');
            }
        }
        //$this->setTemplate('index');
        // print_r("NO Es valido ");        exit;
        $this->maxPager = sfConfig::get('app_max_sugerencias_por_pagina');
        $this->pager = new sfPropelPager(
                        'RgtSugerencia',
                        $this->maxPager
        );

        $this->pager->setCriteria(new Criteria());
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();
    }

}