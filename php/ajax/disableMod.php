<?php
/*

  This file is part of 'webapp-visual-apache2'.

  Copyright 2012 Sergio Lindo - <sergiolindo.empresa@gmail.com>

  'webapp-visual-apache2' is free software: you can redistribute it and/or
  modify it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or (at your
  option) any later version.

  'webapp-visual-apache2' is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
  Public License for more details.

  You should have received a copy of the GNU General Public License along with
  'webapp-visual-apache2'. If not, see <http://www.gnu.org/licenses/>.

*/

;

$return_data = array(
	'return' => false,
	'message' => '',
	'command_output' => array()
);


exec(
	'/usr/sbin/a2dismod '.$_POST['mod_name'].' 2>&1',
	$return_data['command_output']['message'],
	$return_data['command_output']['return']
);

if($return_data['command_output']['return'] != 0) {

	$return_data['message'] = 'MOD_NOT_DISABLED';

} else {

	$return_data['message'] = 'MOD_DISABLED';

	$return_data['return'] = true;

}


// RETURN DATA.
echo json_encode( $return_data );

?>

