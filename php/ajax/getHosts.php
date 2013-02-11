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

// GET HOSTS LIST.

	$hosts_list = array();

	// List directory.
	$dir_sites_available = dir( "/etc/apache2/sites-available" );

	while ( ($element = $dir_sites_available->read()) !== false ) {

		if((preg_match('/.backup$/', $element) != 1
		&& preg_match('/~$/', $element) != 1)
		&& is_file( '/etc/apache2/sites-available/'.$element ) ) {

			// ServerName.
	   		$hosts_list[$element] = array();

			// Read virtual host file.
			$file = file( '/etc/apache2/sites-available/'.$element );


		// GET PORT.

			$port_line = implode( preg_grep( "/<VirtualHost*/", $file ) );

			$start_pos = strpos( $port_line, ':' ) + 1;

			$end_pos = strpos( $port_line, '>' );

			$hosts_list[$element]['port'] = substr(
				$port_line,
				$start_pos,
				$end_pos - $start_pos
			);


		// GET DocumentRoot.

			$document_root_line = implode( preg_grep( "/DocumentRoot/", $file ) );

			$start_pos = strpos( $document_root_line, '/' );

			$hosts_list[$element]['document_root'] = substr(
				$document_root_line,
				$start_pos
			);


		// GET WSGI directive state (Enable / Disable).

			if( strpos( implode( $file ), "WSGIScriptAlias" ) !== false )
				$hosts_list[$element]['wsgi_activated'] = true;
			else
				$hosts_list[$element]['wsgi_activated'] = false;


		// GET host state (Enable / Disable).

			if($element == 'default'
			&& is_file('/etc/apache2/sites-enabled/000-'.$element)
			|| is_file('/etc/apache2/sites-enabled/'.$element)) {

				$hosts_list[$element]['host_activated'] = true;

			} else {

				$hosts_list[$element]['host_activated'] = false;

			}

		}// END OF if( is_file( '/etc/apache2/sites-available/'.$element ) )

	}// END OF while ( ($element = $dir_sites_available->read()) !== false )

	$dir_sites_available->close();


// RETURN HOST_LIST.

	echo json_encode( $hosts_list );

?>
