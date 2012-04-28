<?php

/**
 * gestorAyuda actions.
 *
 * @package    CVE
 * @subpackage gestorAyuda
 * @author     AUTOR
 * @version    1.0.0
 */
class edaGestorAyudasActions extends sfActions
{

    public function executeSeleccionarModuloAyuda($request)
    {
        $this->form = new seleccionModuloAyudaForm();
    }

    public function executeEditarAyuda($request)
    {
        $datos = $request->getParameter('modulo_ayuda');

        $this->form = new seleccionModuloAyudaForm();
        $this->form->bind($datos);
        if ($this->form->isValid())
        {
            $this->aModulo = $this->form->getValue('modulos');
            $this->aPagina = $this->form->getValue('paginas');
            $this->aCultura = $this->form->getValue('idiomas');

            $this->formEdicion = new editaPaginaForm();

            $aRuta = sfConfig::get('sf_web_dir') . '/ayudas/' . $this->aModulo;

            if (file_exists($aRuta))
            {
                if (file_exists($aRuta . '/' . $this->aPagina . '.' . $this->aCultura))
                {
                    $this->aTextoAyuda = file_get_contents($aRuta . '/' . $this->aPagina . '.' . $this->aCultura);
                } else
                {
                    $this->aTextoAyuda = '';
                }

                $this->formEdicion->setDefault('texto', $this->aTextoAyuda);
                if ($this->aPagina != 'op_add_pagina')
                {
                    $this->formEdicion->setDefault('nombre_pagina', $this->aPagina);
                    $this->formEdicion->getWidget('nombre_pagina')->setAttributes(array(
                        'disabled'=>'disabled'));
                }
            } else
            {
                $this->redirect('sftGestorErrores/mensajeError?mensaje=La ruta definida para el fichero de ayuda no es válida.');
            }
        } else // Redirigimos a la pagina de gestión de errores
        {
            //$this->redirect('sftGestorErrores/mensajeError?mensaje=Hay que introducir el módulo y la página.&modulo=edaGestorAyudas&accion=seleccionarModuloAyuda');
            $this->setTemplate('formSeleccionAyudaError');
        }
    }

    public function executeGrabarAyuda($request)
    {
        $aRuta = sfConfig::get('sf_web_dir') . '/ayudas/' . $request->getParameter('modulo');
        $html = $request->getParameter('textoAyuda');

        if (file_exists($aRuta))
        {
            $fp = fopen($aRuta . '/' . $request->getParameter('pagina') . '.' . $request->getParameter('cultura'), 'w');
            fwrite($fp, $html);
            fclose($fp);
        } else
        {
            $this->redirect('sftGestorErrores/mensajeError?mensaje=No existe la ruta!!!');
        }
    }

    /**
     * Executes buscarPaginasModulo action
     *
     * @param sfRequest $request A request object
     */
    public function executeBuscarPaginasModulo($request)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

        $this->form = new seleccionModuloAyudaForm();
        $tPaginas = array();
        if ($request->hasParameter('modulo'))
        {
            $aModulo = $request->getParameter('modulo');
            if (file_exists(sfConfig::get('sf_web_dir') . '/ayudas/' . $aModulo . '/paginas.txt'))
            {
                $tP = array();
                $tP = file(sfConfig::get('sf_web_dir') . '/ayudas/' . $aModulo . '/paginas.txt');
                foreach ($tP as $pagina)
                {
                    $tPaginas[__('Páginas editables')][$pagina] = $pagina;
                }
            }
        }
        $tPaginas[__('Operaciones')]['op_add_pagina'] = __('Añadir nueva página');

        $this->form->setWidget('paginas', new sfWidgetFormChoice(
                        array(
                            'choices' => $tPaginas,
                )));
    }

}
