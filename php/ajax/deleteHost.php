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



// TEST IF HOST DOES NOT EXISTS.

	if( ! is_file( '/etc/apache2/sites-available/'.$_POST['server_name'] ) )

		$return_data['message'] = 'HOST_DOES_NOT_EXIST';



// Other stuff.

	else {

		// Make a backup of the file.
		$backup_created = copy(
			'/etc/apache2/sites-available/'.$_POST['server_name'],
			'/etc/apache2/sites-available/'.$_POST['server_name'].'.backup'
		);

		if( ! $backup_created )
			$return_data['message'] = 'HOST_NO_BACKUP';

		else if( $backup_created ) {

			if( is_file( '/etc/apache2/sites-enabled/'.$_POST['server_name'] ) )

				$return_data['message'] = 'HOST_STILL_ACTIVATED';

			else { // Host is deactivated.

			// REMOVE FILE OF HOST.

				if( ! unlink( '/etc/apache2/sites-available/'.$_POST['server_name'] ) )

					$return_data['message'] = 'HOST_DOES_NOT_REMOVED';

				else { // Host is removed.

					$return_data['message'] = 'HOST_DELETED';

					$return_data['return'] = true;

				}// END OF Host is removed.

			}// END OF Host is deactivated.

		}// END OF else if( $backup_created )

	}// END OF else: OTHER STUFF.


// RETURN DATA.

	echo json_encode( $return_data );

?>

