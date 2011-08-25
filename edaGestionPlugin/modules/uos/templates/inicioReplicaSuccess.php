<div id=container-content>
    <h1 id=header-content >Instalar Aplicación</h1>
     <div id="help-content">
    <p>
      <a href="#" id="Ayuda" name="Ayuda" title="Ver Ayuda" onclick="ventanaNueva('/cviv0007/abiesweb/edae/web/gbib_dev.php/gestorAyuda/ver/modulo/lectores/pagina/index.es_ES','Ayuda','scrollbars=yes,width=790,height=595,top=0,left=0')" onmouseover="javascript:{window.status='Ver Ayuda';return true;}">
        <span id="lblAyudaContenido">Ayuda</span>
      </a>

    </p>
  </div>

    <div id="content"  >

        <div><form id="FormAltaCentro" name="FormAltaCentro" method="post"  action="<?php echo url_for('uos/altaCentro') ?>" enctype="" >
           <span class="mifieldset">
               <span class="cajaform" >                   
                        <label for="IdUONueva" id="IdUONueva_lbl">UO en la que se instalará la aplicación:</label>
                        <?php echo $widgetUOS->render('IdUONueva');?>                   
               </span>
               <span class="cajaform" >
                   
                       <span id="texto_aplicacion"  ><?php echo __('Aplicación a instalar:')?></span>
                   
                   
               </span>
               <span class="cajaform" >
                   
                      <input type="checkbox" id="chech_GBIB" name="chech_GBIB" checked="True" value="GBIB" title=""/>
                      <label for="chech_GBIB" id="chech_GBIB_lbl">Gestor de bibliotecas</label>
                   
                   
               </span>
           </span>

         <input type="submit" id="Submit" name="Submit" value="Aceptar" title="Aceptar" class="boton" />
         </form></div>

  </div>
</div>