<?php $eMenuActivo = $sf_request->getParameter('eMenuActivo', $sf_user->getAttribute('eMenuActivo', 0, 'SftUser')) ?>
<?php $eSubMenuActivo = $sf_request->getParameter('eSubmenuActivo',$sf_user->getAttribute('eSubmenuActivo', 0, 'SftUser')) ?>

  <div id="nav1">
    <ul class="" id="lstnav1">
      <?php $i=0; $nSubmenu=0; ?>
      <?php foreach ($menus['menu'] as $menu): ?>
        <?php if ($i==$eMenuActivo)
        {
          $nSubmenu = $i;
          $aClaseComponente = 'nav1_active';
          $aClaseEnlace = 'menu1';
          //aquí guardar en session menu
          $sf_user->setAttribute('eMenuActivo', $eMenuActivo,'SftUser');
        }
        else
        {
          $aClaseComponente = 'optionmenu1';
          $aClaseEnlace =  'menu2';
        }
        if($menu['tipo']=='edae')
        {
          //$aEnlace = url_for("edae2/edae.php")."?modulo=".urlencode(base64_encode($menu['modulo']))."&".$menu['accion']."&eMenuActivo=".$i."&eSubmenuActivo=0";
          $aEnlace = "";
        }
        else
        {
          if(strrpos($menu['accion'],'?')===false)
            $aEnlace = url_for($menu['accion']."?eMenuActivo=".$i."&eSubmenuActivo=0");
          else
            $aEnlace = url_for($menu['accion']."&eMenuActivo=".$i."&eSubmenuActivo=0");
        }
        ?>
        <li class="<?php echo $aClaseComponente ?>" id="eltomenu00<?php echo $i ?>">
          <?php if($menu['tipo']=='edae'): ?><a style="cursor:text;" title="" name="menu00<?php echo $i ?>" id="menu00<?php echo $i ?>" href="#"><?php else: ?>
          <a onmouseover="javascript:{window.status='<?php echo __($menu['nombre'],null,"menus") ?>';return true;}" class="<?php echo $aClaseComponente ?>" title="<?php echo __($menu['title'],null,"menus") ?>" name="menu00<?php echo $i ?>" id="menu00<?php echo $i ?>" href="<?php echo $aEnlace ?>">
          <?php endif;?>
            <span class="<?php echo $aClaseComponente ?>" id="menu00<?php echo $i ?>_txt"><?php echo __($menu['nombre'],null,"menus") ?></span>
          </a>
        </li>
      <?php $i++ ?>
      <?php endforeach; ?>
    </ul>
  </div>


  <div id="nav2">
    <ul id="lstnav2" class="">
      <?php $submenus = $menus['menu'][$nSubmenu]['menu'] ?>
      <?php $i=0; ?>
      <?php foreach ($submenus as $submenu): ?>
      <?php if ($i==$eSubMenuActivo)
	{
	   $aClaseComponente = 'nav2_active';
           //aquí guardar en session submenu
           $sf_user->setAttribute('eSubmenuActivo', $eSubMenuActivo, 'SftUser');
	}
	else
	{
	   $aClaseComponente = 'optionmenu2';
	}
        if($submenu['tipo']=='edae')
        {
          //$aEnlace = url_for("edae2/edae.php")."?modulo=".urlencode(base64_encode($submenu['modulo']))."&".$submenu['accion']."&eMenuActivo=".$nSubmenu."&eSubmenuActivo=".$i;
          $aEnlace = "";
        }
        else
        {
            if(strrpos($submenu['accion'],'?')===false)
                $aEnlace = url_for($submenu['accion']."?eMenuActivo=".$nSubmenu."&eSubmenuActivo=".$i);
            else
                $aEnlace = url_for($submenu['accion']."&eMenuActivo=".$nSubmenu."&eSubmenuActivo=".$i);
        }
      ?>
      <li id="eltomenu00<?php echo $i ?>" class="<?php echo $aClaseComponente ?>">
        <?php if($submenu['tipo']=='edae'): ?><a style="cursor:text;" title="" name="menu00<?php echo $i ?>" id="menu00<?php echo $i ?>" href="#"><?php else: ?>
        <a href="<?php echo $aEnlace ?>" id="menu_href<?php echo $i ?>" name="menu_href<?php echo $i ?>" title="<?php echo __($submenu['title'],null,"menus") ?>" class="<?php echo $aClaseComponente ?>" onmouseover="javascript:{window.status='<?php echo __($submenu['nombre'],null,"menus") ?>';return true;}">
        <?php endif; ?>
          <span id="menu00<?php echo $i ?>_txt" class="<?php echo $aClaseComponente ?>"><?php echo __($submenu['nombre'],null,"menus");?></span>
        </a>
      </li>
      <?php $i++ ?>
      <?php endforeach; ?>
    </ul>
  </div>