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



// TEST IF HOST EXISTS.

	if( is_file( '/etc/apache2/sites-available/'.$_POST['server_name'] ) )

		$return_data['message'] = 'HOST_EXISTS';



// Other stuff.

	else {

	// MAKE DocumentRoot IF IT DOES NOT EXIST.

		if( ! is_dir( $_POST['document_root'] ) )

			if( ! mkdir( $_POST['document_root'] ) )

				$return_data['message'] = 'NO_DOCUMENT_ROOT';



	// MAKE logs SUBDIR IF IT DOES NOT EXIST.

		if(
			is_dir( $_POST['document_root'] )
			and ! is_dir( $_POST['document_root'].'/logs' )
		)

			if( ! mkdir( $_POST['document_root'].'/logs' ) )

				$return_data['message'] = 'NO_LOGS_DIR';



		if( is_dir( $_POST['document_root'].'/logs' ) ) {

			// Read ports configuration file of apache2.
			$ports_file = file( '/etc/apache2/ports.conf' );

			// Test if apache is listening on this port.
			$is_listening = ( count(
				preg_grep(
					"/^Listen ".$_POST['port']."/",
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

				if( !$backup_created )

					$return_data['message'] = 'NO_BACKUP';

				if( $backup_created ) {

					$lines = implode( $ports_file );

					// Append the new port.
					$lines = preg_replace(
						"/\\nListen /",
						"\nListen ".$_POST['port']."\nListen ",
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
						$return_data['message'] = 'FATAL_ERROR';
					else
						$is_listening = true;

					fclose( $resource_ports_file );

				}// END OF if( $backup_created ).

			}// END OF if( !$is_listening ).



		// CREATE VIRTUAL HOST FILE.

			if( $is_listening ) {

				// Open host file for write only / create.
				$resource_host_file = fopen(
					'/etc/apache2/sites-available/'.$_POST['server_name'],
					'w'
				);

				// Make content.
				$lines = "#Host added by Visual Apache.\n".
				"<VirtualHost *:".$_POST['port'].">\n".
				"\tServerName ".$_POST['server_name']."\n".
				"\n".
				"\tDocumentRoot ".$_POST['document_root']."\n".
				"\t<Directory />\n".
				"\t\tAllowOverride None\n".
				"\t\tOrder allow,deny\n".
				"\t\tAllow from all\n".
				"\t</Directory>\n".
				"\n";
				if( $_POST['wsgi_activated'] == 'true' )
					$lines .= "\tWSGIScriptAlias / ".$_POST['document_root']."/".$_POST['server_name']."/wsgi.py\n\n";
				$lines .= "\tErrorLog ".$_POST['document_root']."/logs/error.log\n".
				"\tCustomLog ".$_POST['document_root']."/logs/access.log combined\n".
				"</VirtualHost>\n";

				// Write content.
				if( ! fwrite( $resource_host_file, $lines ) )
					$return_data['message'] = 'NOT_CREATED';
				else {
					$return_data['return'] = true;
					$return_data['message'] = 'SUCCESS';
				}

				fclose( $resource_host_file );

			}// END OF if( $is_listening ).

		}// END OF if( is_dir( $_POST['document_root'].'/logs' ) ).

	}// END OF else: OTHER STUFF.



// RETURN DATA.

	echo json_encode( $return_data );

?>

