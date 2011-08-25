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
    <?php echo image_tag('ActivosPlugin/menu_izq.gif',array('align'=>'left')) ?>
    <?php echo image_tag('ActivosPlugin/menu_der.gif', array('align'=>'right')) ?>

    <li class="top"><a href="#" class="top_link"><span class="down">UOS</span></a>
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="sub">

            <li><a href="/CVE/SF/Doc/FSDocente.php?bDatosTabla=0">SF</a></li>
            <li><a href="/CVE/SA/AE/OE/Estudios.php">Estudios</a></li>
            <li><a href="/CVE/SA/GA/Cursos/ListadoCursos.php">Cursos</a></li>
            <li><a href="/CVE/SA/GA/Asignaturas/Asignaturas.php">Asignaturas</a></li>

            <li><a href="<?php echo url_for('eda_uos/index') ?>">UOS</a></li>
            <li><a href="<?php echo url_for('eda_perfiles/index') ?>">Perfiles</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>

    <li class="top"><a href="#"  class="top_link"><span class="down">Personas</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="sub">
            <li><a href="<?php echo url_for('eda_personas/index') ?>">Personas</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>

    <li class="top"><a href="#"  class="top_link"><span class="down">Aplicaciones</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="sub">
            <li><a href="<?php echo url_for('eda_aplicaciones/index') ?>">Aplicaciones</a></li>
            <li><a href="<?php echo url_for('eda_credenciales/index') ?>">Credenciales</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
    </li>
</ul>

