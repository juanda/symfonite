<?php use_helper('I18N', 'Date') ?>
<?php include_partial('asociaatributos/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Listado de Atributos ', array(), 'messages') ?>
      <?php if (isset($nombreUsuario)){echo __(' del usuario '.$nombreUsuario, array(),'messages');} ?>
  </h1>
  <?php include_partial('asociaatributos/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('asociaatributos/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_content">
    
    <form action="<?php echo url_for('eda_usu_atributos_valores_asociaatributos_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('asociaatributos/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'id_usuario'=>$id_usuario)) ?>
    <ul class="sf_admin_actions">
        <?php if ($pager->getNbResults()>0){ ?>
            <?php include_partial('asociaatributos/list_batch_actions', array('id_usuario'=>$id_usuario,'pager' => $pager, 'helper' => $helper)) ?>
        <?php }?>
        <?php include_partial('asociaatributos/list_actions', array('id_usuario'=>$id_usuario ,'helper' => $helper)) ?>
    </ul>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('asociaatributos/list_footer', array('pager' => $pager)) ?>
  </div>
</div>

