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
	'message' => ''
);

// Get port.
$host_file = file( '/etc/apache2/sites-available/'.$_POST['server_name'] );
$port_line = implode( preg_grep( "/<VirtualHost*/", $host_file ) );
$start_pos = strpos( $port_line, ':' ) + 1;
$end_pos = strpos( $port_line, '>' );
$port = substr(
	$port_line,
	$start_pos,
	$end_pos - $start_pos
);


// Read ports configuration file of apache2.
$ports_file = file( '/etc/apache2/ports.conf' );
// Test if apache is listening on this port.
$is_listening = ( count(
	preg_grep(
		"/^Listen ".$port."$/",
		$ports_file
	)
) != 0 );


// ADD LISTEN PORT IF APACHE IS NOT LISTENING TO IT.

if( !$is_listening ) {

	// Make a backup of ports configuration file of apache2.
	$backup_created = copy(
		'/etc/apache2/ports.conf',
		'/etc/apache2/ports.conf.backup'
	);

	if( !$backup_created ) {

		$return_data['message'] = 'PORTS_FILE_NO_BACKUP';

	}

	else if( $backup_created ) {

		$lines = implode( $ports_file );

		// Append the new port.
		$lines = preg_replace(
			"/\\nListen /",
			"\nListen ".$port."\nListen ",
			$lines,
			1
		);

		// Open ports configuration file of apache2 for write from beginning.
		$resource_ports_file = fopen(
			'/etc/apache2/ports.conf',
			'r+'
		);

		// Write all the lines.
		if( ! fwrite( $resource_ports_file, $lines ) )
			$return_data['message'] = 'PORTS_FILE_CORRUPTED';
		else
			$is_listening = true;

		fclose( $resource_ports_file );

	}// END OF if( $backup_created ).

}// END OF if( !$is_listening ).


// ENABLE HOST.

	if(is_listening) {

		exec(
			'/usr/sbin/a2ensite '.$_POST['server_name'].' 2>&1',
			$return_data['message'],
			$return_data['return']
		);

	}


// RETURN DATA.
echo json_encode( $return_data );

?>

