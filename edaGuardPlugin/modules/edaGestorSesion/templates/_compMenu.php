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
<ul class="menu2">
    <?php echo image_tag('../ActivosPlugin/images/menu_izq.gif',array('align'=>'left')) ?>
    <?php echo image_tag('../ActivosPlugin/images/menu_der.gif', array('align'=>'right')) ?>

    <?php if(isset($menus)): ?>

    <li class="top">
        <a href="<?php echo url_for($menus['module'].'/'.$menus['action']) ?>" class="top_link"> <span class="down">  <?php echo __($menus['page']) ?></span></a>
    </li>

        <?php foreach ($menus['menu'] as $menu1): ?>

    <li class="top">
                <?php if(isset($menu1['urlExterna']) && $menu1['urlExterna']) : ?>
        <a href="<?php echo $menu1['action'] ?>" target="_blank" class="top_link"> <span class="down">  <?php echo __($menu1['page']) ?></span></a>
                <?php else: ?>
                    <?php if(isset($menu1['ventanaNueva']) && $menu1['ventanaNueva']) : ?>
        <a href="<?php echo url_for($menu1['module'].'/'.$menu1['action']) ?>" target="_blank" class="top_link"> <span class="down">  <?php echo __($menu1['page']) ?></span></a>
                    <?php else: ?>
        <a href="<?php echo url_for($menu1['module'].'/'.$menu1['action']) ?>" class="top_link"> <span class="down">  <?php echo __($menu1['page']) ?></span></a>
                    <?php endif; ?>
                <?php endif; ?>
<!--[if lte IE 6]><table><tr><td><![endif]-->
                <?php if(isset($menu1['menu'])): ?>
        <ul class="sub">
                        <?php foreach ($menu1['menu'] as $menu2): ?>
            <li>
                                <?php if(isset($menu2['urlExterna']) && $menu2['urlExterna']) : ?>
                <a href="<?php echo $menu2['action'] ?>" target="_blank" class="top_link"> <span class="down">  <?php echo __($menu2['page']) ?></span></a>
                                <?php else: ?>
                                    <?php if(isset($menu2['ventanaNueva']) && $menu2['ventanaNueva']) : ?>
                <a href="<?php echo url_for($menu2['module'].'/'.$menu2['action']) ?>" target="_blank" ><?php echo __($menu2['page']) ?></a>
                                    <?php else: ?>
                <a href="<?php echo url_for($menu2['module'].'/'.$menu2['action']) ?>"  ><?php echo __($menu2['page']) ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
            </li>
                        <?php endforeach; ?>
        </ul>
                <?php endif; ?>

        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>

        <?php endforeach; ?>
    <?php else: ?>

    <b>Este perfil no tiene definido ningún menú en esta aplicación</b>

    <?php endif; ?>
</ul>