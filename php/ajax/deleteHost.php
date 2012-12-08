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

$return_data = array(
	'return' => false,
	'message' => ''
);



// TEST IF HOST DOES NOT EXISTS.

	if( ! is_file( '/etc/apache2/sites-available/'.$_POST['server_name'] ) )

		$return_data['message'] = 'HOST_DOES_NOT_EXIST';



// Other stuff.

	else {

	// TEST IF PORT IS USELESS.

		$stuff_of_port_done = false;
		$ports = array();

		// Search used ports.

		$dir_sites_available = dir("/etc/apache2/sites-available");

		while ( ($element = $dir_sites_available->read()) !== false ) {

			if( is_file( "/etc/apache2/sites-available/".$element ) ) {

				// Read file.
				$file = file( "/etc/apache2/sites-available/".$element );

				// Extract port line.
				$port_line = implode( preg_grep( "/^<VirtualHost .+:/", $file ) );

				// Extract port.

				$start_pos = strpos( $port_line, ':' ) + 1;

				$end_pos = strpos( $port_line, '>' );

				$port = substr(
					$port_line,
					$start_pos,
					$end_pos - $start_pos
				);

				// Found port of server_name.
				if( $element == $_POST['server_name'] )
					$deleting_port = $port;

				// Count users of this port.
				if( ! isset( $ports[$port] ) )
					$ports[$port] = 0;
				$ports[$port] ++;

			}// END OF if( is_file( $element )

		}// END OF while ( ($element = $dir_sites_available->read()) !== false )

		$dir_sites_available->close();

		if( $ports[$deleting_port] > 1 )
			$stuff_of_port_done = true;
			
		// Delete port if it is useless.
		else if( $ports[$deleting_port] <= 1 ) {

			// Make a backup of the ports.conf file.
			$backup_created = copy(
				'/etc/apache2/ports.conf',
				'/etc/apache2/ports.conf.backup'
			);

			if( ! $backup_created )
				$return_data['message'] = 'PORT_NO_BACKUP';

			// Write changes.
			else if( $backup_created ) {

				// Delete line of useless port.
				$lines = implode(
					'',
					preg_grep(
						"/^Listen $deleting_port$/",
						file( '/etc/apache2/ports.conf' ),
						PREG_GREP_INVERT
					)
				);

				// Open ports file.
				$resource_ports_file = fopen(
					'/etc/apache2/ports.conf',
					'w'
				);

				// Write all the lines.
				if( ! fwrite( $resource_ports_file, $lines ) )
					$return_data['message'] = 'PORT_FATAL_ERROR';
				else
					$stuff_of_port_done = true;

				fclose( $resource_ports_file );

			}// END OF else if( $backup_created )

		}// END OF else if( $ports[$deleting_port] <= 1 ).

		if( $stuff_of_port_done ) {

		// DEACTIVATE HOST.

			// Make a backup of the file.
			$backup_created = copy(
				'/etc/apache2/sites-available/'.$_POST['server_name'],
				'/etc/apache2/sites-available/'.$_POST['server_name'].'.backup'
			);

			if( ! $backup_created )
				$return_data['message'] = 'HOST_NO_BACKUP';

			else if( $backup_created ) {

				if( is_file( '/etc/apache2/sites-enabled/'.$_POST['server_name'] )
				and ! unlink( '/etc/apache2/sites-enabled/'.$_POST['server_name'] ) )

					$return_data['message'] = 'HOST_STILL_ACTIVATED';


				else { // Host is deactivated.

				// REMOVE FILE OF HOST.

					if( ! unlink( '/etc/apache2/sites-available/'.$_POST['server_name'] ) )

						$return_data['message'] = 'HOST_NOT_REMOVED';


					else { // Host is removed.

						$return_data['return'] = true;
						$return_data['message'] = 'SUCCESS';

					}// END OF Host is removed.

				}// END OF Host is deactivated.

			}// END OF else if( $backup_created )

		}// END OF if( $stuff_of_port_done )

	}// END OF else: OTHER STUFF.



// RETURN DATA.

	echo json_encode( $return_data );

?>

