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

		// CREATE VIRTUAL HOST FILE.

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
				$return_data['message'] = 'HOST_NOT_CREATED';
			else {
				$return_data['return'] = true;
				$return_data['message'] = 'HOST_CREATED';
			}

			fclose( $resource_host_file );

		}// END OF if( is_dir( $_POST['document_root'].'/logs' ) ).

	}// END OF else: OTHER STUFF.



// RETURN DATA.

	echo json_encode( $return_data );

?>

