<style type="text/css"> 
    #breadnavtreetable tr.odd { background-color: #fff; padding: 1em; } 
    #breadnavtreetable tr.even { background-color: #ccc; padding: 1em; }
    #breadnavtreetable td {padding-left: 1em; padding-right: 1em;}
</style> 
<?php use_helper('I18N') ?>
<div id="sf_admin_container">
    <h1>Menú de la aplicación: <?php echo $aplicacion->getNombre() ?></h1>

    <div id="sf_admin_header">

        <div class="hint">
            <?php if (!isset($freshinstall)): ?>
                <?php echo __('Utiliza el formulario de al lado para añadir nuevos items de menú.
               Para editar los existentes pulsa sobre el item en cuestión y actualízalo con dicho formulario.') ?> 
            <?php else: ?>
            <?php echo __('El menú tiene estructura de árbol (como un directorio,) todos los items dependen de un nodo que se crea automáticamente con la aplicación.
                Haz click en el enlace siguiente para añadir el primer item del menú de tu aplicación.') ?>          
            <?php endif; ?>
        </div>
    </div>


    <div id="sf_admin_bar">
        <?php if (!isset($freshinstall)): ?>
            <div class="sf_admin_form">
                <form action="<?php echo url_for('@sfBreadNav2Plugin_indexScope?scope=' . $scope) ?>" method='POST'>

                    <?php echo $form->renderGlobalErrors() ?>
                    <?php echo $form->renderHiddenFields() ?>
                    <fieldset id="sf_fieldset_1">
                        <h2><?php
                if (isset($edit))
                {
                    echo __('Editar') . ': ' . $form->getDefault('page');
                } else
                {
                    echo __('Añadir item de Menú');
                }
                    ?></h2>



                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('página') ?></label>
                                <?php echo $form['page']->renderError() ?>
                                <?php echo $form['page'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('ruta') ?></label>
                                <?php echo $form['route']->renderError() ?>
                                <?php echo $form['route'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('credencial') ?></label>
                                <?php echo $form['credential']->renderError() ?>
                                <?php echo $form['credential'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('catch all') ?></label>
                                <?php echo $form['catch_all']->renderError() ?>
                                <?php echo $form['catch_all'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('menú padre') ?></label>
                                <?php echo $form['parent']->renderError() ?>
                                <?php echo $form['parent'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('orden') ?></label>
                                <?php echo $form['order']->renderError() ?>
                                <?php echo $form['order'] ?>
                            </div>
                        </div>

                        <div class="sf_admin_form_row">
                            <div>
                                <label for="textedit2"><?php echo __('posición') ?></label>
                                <?php echo $form['order_option']->renderError() ?>
                                <?php echo $form['order_option'] ?>
                            </div>
                        </div>

                    </fieldset>


                    <ul class="sf_admin_actions">
                        <li><input type='submit' value='<?php
                            if (isset($edit))
                            {
                                echo _('Actualizar item');
                            } else
                            {
                                echo __('Añadir item');
                            }
                                ?>' /></li>
                    </ul>
                </form>
            </div>

            <?php if (isset($edit)): ?>
                <div class="sf_admin_form">
                    <form method="post" action='<?php echo url_for('@sfBreadNav2Plugin_DeletePage?pageid=' . $form->getDefault('id') . "&scope=" . $scope); ?>'>

                        <ul class="sf_admin_actions">
                            <li>
                                <a href='<?php echo url_for('@sfBreadNav2Plugin_indexScope?scope=' . $scope) ?>'><?php echo __('Nuevo Item') ?></a>
                            </li>
                            <li>
                                <input type='submit' value="<?php echo __('borrar') ?>" onclick="if (!confirm('Are you sure?')){return false;}">  
                            </li>
                        </ul>
                    </form>
                </div>
            <?php endif; ?> 

        <?php endif; ?>
    </div>


    <div id="sf_admin_content">
        <form>
            <div class="sf_admin_list">
                <?php include_partial('select_menu', array('form' => $scopeform)); ?>
                <?php
                if (isset($freshinstall))
                {
                    echo '<div class="sf_admin_container"><ul class="sf_admin_actions"><li>'.link_to(__('Crear item de menú de inicio'), '@sfBreadNav2Plugin_editaMenu?scope=' . $scope).'</li></ul></div>';
                    return;
                } else
                {
                    if (!is_null($scope))
                    {
                        include_partial('page_tree', array('scope' => $scope));
                    }
                }
                ?>
            </div>
        </form>
    </div>

    <div id="sf_admin_footer">
    </div>

</div>