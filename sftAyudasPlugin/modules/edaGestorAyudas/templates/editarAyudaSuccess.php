<?php use_helper('jQuery') ?>
<?php use_themes_javascript('tinymce/tiny_mce.js') ?>
<?php use_themes_javascript('jquery/js/jquery.1.6.2.min.js') ?>
<div id="container-content">
    <h1 id="header-content">Editar ayuda</h1>
 </div>
 <div id="content">



<form name="editarAyuda" action="<?php echo url_for('edaGestorAyudas/grabarAyuda') ?>" method="post">
  <strong>Módulo</strong>:<?php echo $aModulo ?> <br/>
  <strong>Página</strong>:<?php echo $aPagina ?><br/>
  <strong>Cultura</strong>:<?php echo $aCultura ?><br/><br/>


  <?php echo $formEdicion->renderGlobalErrors() ?>
  <?php echo $formEdicion->renderHiddenFields() ?>

  <?php echo $formEdicion['nombre_pagina']->renderError() ?>
  <?php echo $formEdicion['nombre_pagina'] ?>

  <?php echo $formEdicion['texto']->renderError() ?>
  <?php echo $formEdicion['texto']->render(array('id'=>'textoAyuda')) ?>

<input type="hidden" name="modulo" value="<?php echo $aModulo ?>"/>
<input type="hidden" name="pagina"  value="<?php echo $aPagina  ?>"/>
<input type="hidden" name="cultura"  value="<?php echo $aCultura  ?>"/>

<script type="text/javascript">
  tinyMCE.init({
    mode:                              "exact",
    elements:                          "textoAyuda",
    theme:                             "advanced",
    content_css :                      "<?php echo stylesheet_path('CSS_2/abies.css') ?>",
    width:                             800,
    height:                            450,
    theme_advanced_toolbar_location:   "top",
    theme_advanced_toolbar_align:      "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing:           true

  });
</script>


  
<input type="submit" class="botonprincipal" value="grabar"/>

</form>
</div>