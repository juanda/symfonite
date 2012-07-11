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
<?php use_stylesheet('../sftRegistroPlugin/css/sugerencias.css') ?>

<div id="sf_admin_container">
    <div class="sf_admin_content">
        <div class="sf_admin_list">
            <h1>Sugerencias</h1>
        </div>
        <?php include_partial('sugerencias/list', array('sugerencias' => $pager->getResults(),
                                                                                                                'paginador' => $pager,
                                                                                                                 'maxPager' => $maxPager)); ?>
        <div class="paginacion_sug_desc">
            <?php if($pager->getPage()*$maxPager >= $pager->getNbResults()):?>
            <?php $viendo = $pager->getNbResults(); ?>
            <?php else: ?>
            <?php $viendo = $pager->getPage()*$maxPager;?>
            <?php endif;?>
            Viendo <strong><?php echo $viendo ?></strong> de <strong><?php echo $pager->getNbResults() ?></strong> sugerencias
        </div>

        <?php if ($pager->haveToPaginate()): ?>
        
            <div class="pagination rgtPagination">
                <a href="<?php echo url_for('@sugerencias') ?>?page=1">
                    <<
                </a>

                <a href="<?php echo url_for('@sugerencias') ?>?page=<?php echo $pager->getPreviousPage() ?>">
                    <
                </a>

                <?php foreach ($pager->getLinks() as $page): ?>
                    <?php if ($page == $pager->getPage()): ?>
                        <?php echo $page ?>
                    <?php else: ?>
                        <a href="<?php echo url_for('@sugerencias') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>

                <a href="<?php echo url_for('@sugerencias') ?>?page=<?php echo $pager->getNextPage() ?>">
                    >
                </a>

                <a href="<?php echo url_for('@sugerencias') ?>?page=<?php echo $pager->getLastPage() ?>">
                    >>
                </a>
            </div>
        <?php endif; ?>

        <form id="nuevaSugerencia" name="nuevaSugerencia" method="POST" action="<?php echo url_for('@sugerencias') ?>">
            <?php echo $formSugerencia->renderGlobalErrors() ?>
            <?php echo $formSugerencia->renderHiddenFields() ?>

            <div  class="sf_admin_form_row sf_admin_text">
                <?php echo $formSugerencia['sugerencia']->renderError() ?>
                <label for="<?php echo $formSugerencia->getName() . "[" . $formSugerencia['sugerencia']->getName() . "]" ?>">Sugerencia:</label>
                <textarea cols="60" rows="10" name="<?php echo $formSugerencia->getName() . "[" . $formSugerencia['sugerencia']->getName() . "]" ?>"><?php echo $formSugerencia['sugerencia']->getValue(); ?></textarea>
            </div>
            <input type="submit" name="enviar" value="Enviar sugerencia"/>
        </form>
    </div>
</div>

