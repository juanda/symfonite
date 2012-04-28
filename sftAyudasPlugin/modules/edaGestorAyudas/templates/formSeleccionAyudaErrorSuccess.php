<?php use_helper('jQuery') ?>
<div id="container-content">
    <h1 id="header-content">Gestor de Ayudas</h1>
</div>
<div id="content">
    <form name="editarAyuda" action="<?php echo url_for('edaGestorAyudas/editarAyuda') ?>" method="post">
        <?php echo $form->renderGlobalErrors()?>
        <?php echo $form->renderHiddenFields()?>
        <div class="titular">Indique el módulo y la página del mismo al que va a crear la ayuda</div>

        <div style="float:left;">
            <?php echo $form['modulos']->renderError() ?>
            <?php echo $form['modulos']->render(array('id' => 'cmb_modulos')) ?>
        </div>
        <script type="text/javascript">
            $('#cmb_modulos').change(function() {$('#capa_paginas_idioma').load('<?php echo url_for('edaGestorAyudas/buscarPaginasModulo') ?>/modulo/'+$('#cmb_modulos').val())});
        </script>

        <div id="capa_paginas_idioma" style="float:left;">
            <div style="float:left;">
                <?php echo $form['paginas']->render(array('id' => 'cmb_paginas')) ?>
            </div>


            <div style="float:left;">
                <?php echo $form['idiomas']->render(array('id' => 'cmb_cultura')) ?>
            </div>

            <div style="float:left;">
                <input type="submit"  class="botonprincipal" value="seleccionar"/>
            </div>

        </div>

    </form>
</div>
