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

// REQUIRED FILES.

	// Languages.
	$language_files = array();
	$i = 0;
	$lang_dir = dir("php/lang");
	while ( ($file = $lang_dir->read()) !== false ) {

		if( strpos( $file, '.php' ) !== false ) {

	   		require_once "php/lang/$file";

			$language_files[$i] = $file;
			$i ++;

		}

	}
	$lang_dir->close();



// DETECT USER LANG.

	if( isset( $_GET['iso_lang'] ) )
		$iso_lang = $_GET['iso_lang'];
	else
		$iso_lang = substr( $_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2 );

	if( !isset( $LANG[$iso_lang] ) )
		$iso_lang = 'en';



// GET HTML TEMPLATE.

	$file = file( 'html/layout.html' );



// PUT CONTENT AND SHOW HTML.

	for( $i = 0; $i < count($file); $i++ ) {

	// Global variables from PHP to JS.

		if( strpos( $file[$i], '{{PHP_TO_JS}}' ) ) {

			$lines = '';

		// Create object names.

			$lines .= "\n\t\t// Create object names.\n";

			// Read a language file.
			$file_php_lang_es = file( 'php/lang/es.php' );

			// Get only delaration lines.
			$variable_declaration_lines = preg_grep(
				"/^[$]/",
				$file_php_lang_es
			);

			foreach( $variable_declaration_lines as $key => $value ) {

				// Variable name ends.
				$end_position = strpos( $value, '[' );

				// Extract variable name.
				$variable_name = substr( $value, 0, $end_position );

				// Make declaration sentence.
				$lines .= "\t\tvar $variable_name = new Object();\n";

			}

		// Fill with values.

			foreach( $language_files as $key => $value ) {

				$lines .= "\n\t\t// $value language values.\n";

				// Read file.
				$file_php_lang = file( "php/lang/$value" );

				// Get only delaration lines.
				$variable_declaration_lines = preg_grep(
					"/^[$]/",
					$file_php_lang
				);

				// Reuse declaration lines.
				foreach( $variable_declaration_lines as $key => $value ) {

					// Make declaration sentence.
					$lines .= "\t\t$value";

				}

			}

		// Show html.

			$file[$i] = str_replace(
				'{{PHP_TO_JS}}',
				$lines,
				$file[$i]
			);

		}// END OF if( strpos( $file[$i], '{{PHP_TO_JS}}' ) ).


	// Static texts.

		$file[$i] = str_replace(
			'{{ISO_LANG}}',
			$iso_lang,
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{META_TITLE}}',
			$META_TITLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{MENU_BAR_TITLE}}',
			$MENU_BAR_TITLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{MENU_BAR_HOSTS}}',
			$MENU_BAR_HOSTS[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{MENU_BAR_MODULES}}',
			$MENU_BAR_MODULES[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{SECTION_HOSTS_TITLE}}',
			$SECTION_HOSTS_TITLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{SECTION_NEW_HOST_TITLE}}',
			$SECTION_NEW_HOST_TITLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{SECTION_MODS_TITLE}}',
			$SECTION_MODS_TITLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_ENABLE}}',
			$BTN_ENABLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_DISABLE}}',
			$BTN_DISABLE[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_SAVE_ENABLE_HOST}}',
			$BTN_SAVE_ENABLE_HOST[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_SAVE_HOST}}',
			$BTN_SAVE_HOST[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_CANCEL_HOST}}',
			$BTN_CANCEL_HOST[$iso_lang],
			$file[$i]
		);

		$file[$i] = str_replace(
			'{{BTN_DELETE_HOST}}',
			$BTN_DELETE_HOST[$iso_lang],
			$file[$i]
		);


	// Choose language menu (Languages available)

		if( strpos( $file[$i], '{{LANGUAGES_AVAILABLE}}' ) !== false ) {

			$lines = '';
			foreach( $LANG as $key => $value ) {
				$lines .= '<a class="menuItem" href="/?iso_lang='.$key.'">'.$value.'</a>'."\n\t\t";
			}

			$file[$i] = str_replace(
				'{{LANGUAGES_AVAILABLE}}',
				$lines,
				$file[$i]
			);

		}


	// Show html.			

		echo $file[$i];

	}// END OF for( $i = 0; $i < count($file); $i++ )

?>
