Proceso de Registro de Usuarios
===============================

.. header:: *Proceso de Registro de Usuarios* - **###Section###**

.. footer:: *Página ###Page###*

.. image:: intef.jpg
    :align: center

:Autor: Álvaro Peláez Santana <alvaro.pelaez@serbal.pntic.mec.es>
:Versión: 1.0

.. contents:: Contenidos


.. raw:: pdf

   PageBreak oneColumn


Introducción
------------

Este pequeño tutorial explica como activar, desactivar y usar el proceso de registro de usuarios en *symfonite*. Este proceso sirve para dar de alta nuevos usuarios, así como darles distintos perfiles y permisos desde un principio.


Requisitos
----------

`SymfonITE 1.2 <http://ntic.educacion.es/desarrollo/symfonite/index.php>`_. Una instalación de *SymfonITE* por defecto, con la aplicación de administración ya creada (seguir primeros pasos del tutorial de *SymfonITE: despliegue del sistema*.

Instalación
-----------

Ejecutar desde terminal, estando situados en la carpeta raíz del proyecto *symfonite* el siguiente comando:

.. code-block:: sh

   php /home/apes0066/sites/sft/symfony generate:appITE --clave=clave_deseada --titulo='Titulo_deseado' --es_registro=true --url="url_deseada" nombre_aplicacion

Donde podemos elegir los campos clave, título, la url para nuestra aplicación, y el nombre de la aplicación, por ejemplo:

.. code-block:: sh

   php /home/apes0066/sites/sft/symfony generate:appITE --clave=832938s98s989d9 --titulo='Registro' --es_registro=true --url="http://localhost/sft/web/registro.php" registro

Este comando creará automáticamente la aplicación de auto-registro, con todas las configuraciones necesarias. Sin embargo para que el envío de emails a los usuarios que deseen registrarse funcione correctamente queda aún un paso. Hay que modificar el mailer en el archivo factories.yml de la carpeta /conf de la aplicación de registro para añadirle los datos del servidor de correo, por ejemplo:

.. code-block:: yaml

  all:

    ...

    mailer:
      param:
        transport:
          param:
            host:       mi_host
            port:       puerto
            username:   nombre_usuario
            password:   contraseña

Una vez terminados estos pasos la aplicación de auto-registro debería funcionar correctamente.

Configuración
-------------

En el archivo de configuración de la aplicación (*/nombre_aplicacion/config/app.yml*), se encuentran todos los parámetros de configuración:

.. code-block:: yaml

  all:
    clave: 832938s98s989d9
    codigo: registro
    max_num_login_fails: 3
    titulo: Registro
    tema: ite
    .array: { assets: { javascripts: [jquery/js/jquery-1.6.2.min.js], stylesheets: [native/css/default.css, native/css/admin.css] } }
    mantenimiento: { activo: 0, url_modulo: sftGestorErrores, url_accion: mantenimiento }
    password_expire: 30
    registro_enabled: true
    id_periodo_inicial: 2
    id_perfil_inicial: 2

De los cuales nos interesan especialmente los tres últimos. Si ponemos *registro_enabled: false* desactivaremos el auto-registro, lo que impedirá que se registren usuarios hasta que volvamos a ponerlo a 'true' (los usuarios ya registrados seguirán teniendo sus perfiles y credenciales".

*id_perfil_inicial* denotará el perfil que se le asignara a cada usuario que se auto-registre, lo que luego nos permitirá darle las credenciales que deseemos a ese perfil. Hay que tener en cuenta que si cambiamos esta configuración, solo tendrá efecto en los usuarios que se auto-registren a partir de este cambio, quedando los usuarios anteriormente registrados con el perfil que tuviesen.

Esto mismo es aplicable a *id_periodo_inicial* con el periodo.  


Uso
---

Para acceder al autoregistro no se necesita estar logeado en el sistema *symfonite*, simplemente debemos acceder a la dirección *http://url_aplicacion/registro*  que tendrá el siguiente aspecto:

.. image:: registro.png
    :align: center

Rellenamos los datos, y el sistema nos enviará automáticamente un email en el que vendrá nuestro nombre de usuario y un enlace para confirmar el registro. Al pulsar el enlace, este nos llevará de nuevo a la aplicación de registro, informándonos de que hemos sido dados de alta. ahora ya podemos logearnos con nuestro nombre de usuario y contraseña.

En caso de que el email ya hubiese sido registrado el sistema nos informará para que metamos uno distinto.

Changelog
---------

- **1.2 -** Se ha incluido en *symfonite* la opción de crear automáticamente una aplicación de registro con una tarea. Esta aplicación hace uso de este plugin de registro (*SftRegistroPlugin*)
- **1.1 -** El proceso de registro de usuarios ha sido convertido en un plugin *symfonite*
- **1.0 -** Primera versión del proceso de registro de usuarios.4866