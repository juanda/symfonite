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
<br/>
<div id="content">	
	<select id="seleccion" onchange="document.location='<?php echo url_for('logs/lista?logs='); ?>'+this.value">
		<option onclick="" selected>
			<?php echo __("Elija los logs a visualizar")?></option>
		<?php foreach ($lista_opciones as $elemento):?>		
			<option value="<?php echo $elemento['clave']?>" >
				<?php echo __("Logs de ".$elemento['nombre'])?></option>			
		<?php endforeach;?>
	</select>	
	<div>
		<?php if (!$error && count($lista_def)>0): ?>
		<table id="TablaListadoErrores" class="" summary="">
			<tr>
				<th><span id="titulo"><?php echo __("Ficheros")?></span></th>
				<th><span id="titulo"><?php echo __("Acciones")?></span></th>
			</tr>
			<?php foreach ($lista_def as $nombre):?>
			<tr>
				<td scope="col"><span id="archivo"><?php echo $nombre ?></span>
				</td>
				<td scope="col">
					<div id="acciones">
						<a target="_blank" href="<?php echo url_for('logs/ver?nombre='.$nombre); ?>" id="accionvar" title="">
							<?php echo image_tag('../css/CSS_2/icover.gif',array('id'=>"ver", "alt"=>__("Ver"), "title"=>__("ver")))?>
						</a>
						<a href="<?php echo url_for('logs/descargar?nombre='.$nombre); ?>" id="acciondesc" title="">
							<?php echo image_tag('../css/CSS_2/icoguardar.gif',array('id'=>"ver", "alt"=>__("Descargar"), "title"=>__("Descargar")))?>
						</a> 
						<a 	href="<?php echo url_for('logs/borrar?nombre='.$nombre.'&lista='.$lista); ?>" id="accionbor" title="">
							<?php echo image_tag('../css/CSS_2/icoborrar.gif',array('id'=>"ver", "alt"=>__("Borrar"), "title"=>__("Borrar")))?>
						</a>
					</div>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<!--  Falta el else del error -->
		<?php endif;?>	
	</div>
</div>