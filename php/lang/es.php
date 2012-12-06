<?php
/*

  This file is part of 'web-app-visual-apache'.

  Copyright 2012 Sergio Lindo - <sergiolindo.empresa@gmail.com>

  'web-app-visual-apache' is free software: you can redistribute it and/or
  modify it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or (at your
  option) any later version.

  'web-app-visual-apache' is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
  Public License for more details.

  You should have received a copy of the GNU General Public License along with
  'web-app-visual-apache'. If not, see <http://www.gnu.org/licenses/>.

*/

;

$LANG['es'] = 'Español';

$META_TITLE['es'] = 'Interfaz gráfica para la configuración de apache';
$MENU_BAR_TITLE['es'] = 'Barra de menú';
$MENU_BAR_HOSTS['es'] = 'Hosts';
$MENU_BAR_MODULES['es'] = 'Módulos';

$SECTION_HOSTS_TITLE['es'] = 'Configuración de hosts virtuales';

$SECTION_NEW_HOST_TITLE['es'] = 'Crear host virtual';
$SECTION_NEW_HOST_HOST_EXISTS['es'] = 'El host {{SERVER_NAME}} ya existe.';
$SECTION_NEW_HOST_NO_DOCUMENT_ROOT['es'] = 'No se ha podido crear el directorio {{DOCUMENT_ROOT}}.';
$SECTION_NEW_HOST_NO_LOGS_DIR['es'] = 'No se ha podido crear el subdirectorio {{DOCUMENT_ROOT}}/logs.';
$SECTION_NEW_HOST_NO_BACKUP['es'] = 'No se pudo crear una copia de seguridad del fichero /etc/apache2/ports.conf.';
$SECTION_NEW_HOST_FATAL_ERROR['es'] = 'Error crítico al modificar el fichero /etc/apache2/ports.conf. Apache puede dejar de funcionar. Debería restaurar la copia de seguridad /etc/apache2/ports.conf.backup.';
$SECTION_NEW_HOST_NOT_CREATED['es'] = 'Error al crear el fichero /etc/apache2/sites-available/{{SERVER_NAME}}.';
$SECTION_NEW_HOST_SUCCESS['es'] = 'Host {{SERVER_NAME}} creado con éxito.';

$SECTION_EDIT_HOST_TITLE['es'] = 'Editar host virtual';

$SECTION_MODS_TITLE['es'] = 'Configuración de módulos';

$BTN_ENABLE['es'] = 'Activar';
$BTN_DISABLE['es'] = 'Desactivar';
$BTN_SAVE_ENABLE_HOST['es'] = 'Guardar y activar';
$BTN_SAVE_HOST['es'] = 'Guardar';
$BTN_CANCEL_HOST['es'] = 'Cancelar';
$BTN_DELETE_HOST['es'] = 'Eliminar';

?>
