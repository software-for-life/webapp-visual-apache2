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

// GET MODS LIST.

	$mods_list = array();

	// List directory.
	$dir_mods_available = dir( "/etc/apache2/mods-available" );

	while ( ($element = $dir_mods_available->read()) !== false ) {

		if(preg_match('/.load$/', $element) == 1
		&& is_file( '/etc/apache2/mods-available/'.$element )) {

			// Module name.
			$mod_name = substr($element, 0, strlen($element) - 5);
	   		$mods_list[$mod_name] = array();


		// GET mod state (Enable / Disable).

			if(is_file('/etc/apache2/mods-enabled/'.$element)) {

				$mods_list[$mod_name]['mod_activated'] = true;

			} else {

				$mods_list[$mod_name]['mod_activated'] = false;

			}

		}// END OF if( is_file( '/etc/apache2/mods-available/'.$element ) )

	}// END OF while ( ($element = $dir_mods_available->read()) !== false )

	$dir_mods_available->close();


	// Alphabetical order.
	ksort( $mods_list );


// RETURN MODS_LIST.

	echo json_encode( $mods_list );

?>
