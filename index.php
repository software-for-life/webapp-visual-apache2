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

// REQUIRED FILES.

	// Languages.
	$lang_dir = dir("php/lang");
	while ( ($file = $lang_dir->read()) !== false )
		if( strpos( $file, '.php' ) !== false ) {
	   		require_once "php/lang/$file";
			substr( $file, 0, 2 );
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

		if( strpos( $file[$i], '<script src="js/visualapache.js"></script>' ) ) {

			echo "\t<script>\n\t\t// Global variables from PHP to JS. (Added by index.php controller)\n";

			echo "\t\tvar \$iso_lang = '$iso_lang';\n";

			echo "\t\tvar \$LANG = {\n";
			foreach( $LANG as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$META_TITLE = {\n";
			foreach( $META_TITLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$MENU_BAR_TITLE = {\n";
			foreach( $MENU_BAR_TITLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$MENU_BAR_HOSTS = {\n";
			foreach( $MENU_BAR_HOSTS as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$MENU_BAR_MODULES = {\n";
			foreach( $MENU_BAR_MODULES as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$SECTION_HOSTS_TITLE = {\n";
			foreach( $SECTION_HOSTS_TITLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$SECTION_NEW_HOST_TITLE = {\n";
			foreach( $SECTION_NEW_HOST_TITLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$SECTION_MODS_TITLE = {\n";
			foreach( $SECTION_MODS_TITLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$BTN_ENABLE = {\n";
			foreach( $BTN_ENABLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$BTN_DISABLE = {\n";
			foreach( $BTN_DISABLE as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$BTN_SAVE_ENABLE_HOST = {\n";
			foreach( $BTN_SAVE_ENABLE_HOST as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$BTN_SAVE_HOST = {\n";
			foreach( $BTN_SAVE_HOST as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t\tvar \$BTN_CANCEL_HOST = {\n";
			foreach( $BTN_CANCEL_HOST as $key => $value )
				echo "\t\t\t$key: '".$value."',\n";
			echo "\t\t};\n";

			echo "\t</script>\n";

		}// END OF if( strpos( $file[$i], '<script src="js/visualapache.js"></script>' ) )


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


	// Languages available

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
