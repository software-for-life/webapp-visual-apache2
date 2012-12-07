<?php
/*

  This file is part of 'web-app-visual-apache'.

  Copyright 2012 Sergio Lindo - <sergiolindo.emprena@gmail.com>

  'web-app-visual-apache' is free software: you can redistribute it and/or
  modify it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or (at your
  option) any later version.

  'web-app-visual-apache' is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNenS FOR A PARTICULAR PURPOSE.  See the GNU General
  Public License for more details.

  You should have received a copy of the GNU General Public License along with
  'web-app-visual-apache'. If not, see <http://www.gnu.org/licensen/>.

*/

;

$LANG['en'] = 'English';

$META_TITLE['en'] = 'Graphic interface to configure apache';
$MENU_BAR_TITLE['en'] = 'Menu bar';
$MENU_BAR_HOSTS['en'] = 'Hosts';
$MENU_BAR_MODULES['en'] = 'Modules';

$SECTION_HOSTS_TITLE['en'] = 'Virtual hosts configuration';

$SECTION_NEW_HOST_TITLE['en'] = 'New virtual host';
$SECTION_NEW_HOST_HOST_EXISTS['en'] = 'Host {{SERVER_NAME}} exists.';
$SECTION_NEW_HOST_NO_DOCUMENT_ROOT['en'] = 'Could not create {{DOCUMENT_ROOT}} dir.';
$SECTION_NEW_HOST_NO_LOGS_DIR['en'] = 'Could not create {{DOCUMENT_ROOT}}/logs dir.';
$SECTION_NEW_HOST_NO_BACKUP['en'] = 'Could not create backup of /etc/apache2/ports.conf.';
$SECTION_NEW_HOST_FATAL_ERROR['en'] = 'Fatal error. Maybe /etc/apache2/ports.conf has been corrupted. Apache could stop working. You should restore from /etc/apache2/ports.conf.backup.';
$SECTION_NEW_HOST_NOT_CREATED['en'] = 'Could not create /etc/apache2/sites-available/{{SERVER_NAME}}.';
$SECTION_NEW_HOST_SUCCESS['en'] = 'Host {{SERVER_NAME}} created.';

$SECTION_EDIT_HOST_TITLE['en'] = 'Edit virtual host';

$SECTION_DELETE_HOST_HOST_DOES_NOT_EXIST['en'] = 'Host {{SERVER_NAME}} does not exist.';
$SECTION_DELETE_HOST_PORT_NO_BACKUP['en'] = 'Could not create backup of /etc/apache2/ports.conf.';
$SECTION_DELETE_HOST_PORT_FATAL_ERROR['en'] = 'Fatal error. Maybe /etc/apache2/ports.conf has been corrupted. Apache could stop working. You should restore from /etc/apache2/ports.conf.backup.';
$SECTION_DELETE_HOST_SUCCESS['en'] = 'Host {{SERVER_NAME}} deleted.';



$SECTION_MODS_TITLE['en'] = 'Modules configuration';

$BTN_ENABLE['en'] = 'Enable';
$BTN_DISABLE['en'] = 'Disable';
$BTN_SAVE_ENABLE_HOST['en'] = 'Save and enable';
$BTN_SAVE_HOST['en'] = 'Save';
$BTN_CANCEL_HOST['en'] = 'Cancel';
$BTN_DELETE_HOST['en'] = 'Delete';

?>
