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

// GLOBAL VARIABLES.

	document.object_list_of_hosts;
	document.object_list_of_mods;



$(document).ready(function(){

// ON READY DO

	// Hide modules section.
	$("#sectionMods").fadeOut(0);

	refresh_hosts_list();
	refresh_mods_list();



// EVENTS

	// Menu bar.

		// aHosts click.
		$("#aHosts").click(function(event) {

			event.preventDefault();

			$("#aMods img").attr("src", "img/iconModOn.png");
			$("#sectionMods").fadeOut(
				100,
				function() {
					$("#aHosts img").attr("src", "img/iconHostOff.png");
					$("#sectionHosts").fadeIn(100);
					$("#sectionNewHost").fadeIn(100);
				}
			);

		});// END of aHosts click.

		// aMods click.
		$("#aMods").click(function(event) {

			event.preventDefault();

			$("#aHosts img").attr("src", "img/iconHostOn.png");
			$("#sectionHosts").fadeOut(100);
			$("#sectionNewHost").fadeOut(
				100,
				function() {
					$("#aMods img").attr("src", "img/iconModOff.png");
					$("#sectionMods").fadeIn(100);
				}
			);

		});// END of aMods click.



	// List of hosts.

		// List item click.
		document.list_item_click = function( event ) {

		// Reuse new host section.

			// Change new host section title.
			$('#sectionNewHost header h1').html(
				$SECTION_EDIT_HOST_TITLE[$iso_lang]
			);

			// Fill with host data.
			$('#txtOldServerName').val( event.srcElement.innerHTML );
			$('#txtServerName').val( event.srcElement.innerHTML );
			$('#txtListen').val(
				document.object_list_of_hosts[event.srcElement.innerHTML].port
			);
			$('#txtDocumentRoot').val(
				document.object_list_of_hosts[event.srcElement.innerHTML].document_root
			);
			if( document.object_list_of_hosts[event.srcElement.innerHTML].wsgi_activated )
				$('#btnEnableWSGI').click();
			else
				$('#btnDisableWSGI').click();
			$('#btnDeleteHost').fadeIn(0);

		}// END OF List item click.


		// btnEnableHost click.
		document.btnEnableHost_click = function(e) {

			var server_name;

			server_name = $(e.srcElement).parent().parent().find('td:first').html();

			enable_host(server_name);

			// Show info.
			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_hosts_list();
			$('#btnCancelHost').click();

		}// END OF btnEnableHost click.


		// btnDisableHost click.
		document.btnDisableHost_click = function(e) {

			var server_name;

			server_name = $(e.srcElement).parent().parent().find('td:first').html();

			disable_host(server_name);

			// Show info.
			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_hosts_list();
			$('#btnCancelHost').click();

		}// END OF btnDisableHost click.


	// New hosts.

		// btnEnableWSGI click.
		$('#btnEnableWSGI').click(function(event) {

			if( ! $(this).hasClass( 'disabled' ) ) {

				$('#btnDisableWSGI').removeClass( 'disabled' );
				$(this).addClass( 'disabled' );

			}

		});// END OF btnEnableWSGI click.

		// btnDisableWSGI click.
		$('#btnDisableWSGI').click(function(event) {

			if( ! $(this).hasClass( 'disabled' ) ) {

				$('#btnEnableWSGI').removeClass( 'disabled' );
				$(this).addClass( 'disabled' );

			}

		});// END OF btnDisableWSGI click.

		// btnSaveHost click.
		$('#btnSaveHost').click(function(event) {

			var title = $('#sectionNewHost header h1').html(), success;

			if(title == $SECTION_NEW_HOST_TITLE[$iso_lang]) {
				success = new_host();
			} else if(title == $SECTION_EDIT_HOST_TITLE[$iso_lang]) {
				success = edit_host();
			}

		// Show info.

			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_hosts_list();
			$('#btnCancelHost').click();

		});// END OF btnSaveHost click.

		// btnSaveEnableHost click.
		$('#btnSaveEnableHost').click(function(e) {

			var title = $('#sectionNewHost header h1').html(), success;

			if(title == $SECTION_NEW_HOST_TITLE[$iso_lang]) {
				success = new_host() && enable_host($('#txtServerName').val());
			} else if(title == $SECTION_EDIT_HOST_TITLE[$iso_lang]) {
				success = edit_host() && enable_host($('#txtServerName').val());
			}

		// Show info.

			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_hosts_list();
			$('#btnCancelHost').click();

		});// END OF btnSaveEnableHost click.

		// btnCancelHost click.
		$('#btnCancelHost').click(function(event) {

			$('#sectionNewHost header h1').html(
				$SECTION_NEW_HOST_TITLE[$iso_lang]
			);
			$('#txtOldServerName').val( '' );
			$('#txtServerName').val( '' );
			$('#txtListen').val( '' );
			$('#txtDocumentRoot').val( '' );
			$('#btnDisableWSGI').click();
			$('#btnDeleteHost').fadeOut(0);
		});

		// btnDeleteHost click.
		$('#btnDeleteHost').click(function(event) {

			delete_host();


		// Show info.

			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_hosts_list();
			$('#btnCancelHost').click();

		});// END OF btnDeleteHost click.

});


	// List of Mods.

		// btnEnableMod click.
		document.btnEnableMod_click = function(e) {

			var mod_name;

			mod_name = $(e.srcElement).parent().parent().find('td:first').html();

			enable_mod(mod_name);

			// Show info.
			$('#divMask')
				.fadeIn( 100 )
				.delay( 3000 )
				.fadeOut( 100, function() {
					$('#divMask label.message').html( '' );
					$('#divMask label.message').css({
						color: 'black',
						'font-weight': 'normal'
					});
				})
			;

			refresh_mods_list();

		}// END OF btnEnableMod click.


// FUNCTIONS

function refresh_hosts_list() {

	// Get hosts list.
	$.ajax({

		url: "php/ajax/getHosts.php"

	}).done(function( json_encoded_hosts_list ) {

		var lines = '';

		// Decode json.
		document.object_list_of_hosts = eval( "(" + json_encoded_hosts_list + ")" );

		for( var host_name in document.object_list_of_hosts ) {

			// Get host state.
			if( document.object_list_of_hosts[host_name].host_activated ) {

				btnEnableHost_disabled = ' disabled';
				btnDisableHost_disabled = '';

			} else {

				btnEnableHost_disabled = '';
				btnDisableHost_disabled = ' disabled';

			}

			// Show html.
			lines += '' +
			'<tr>' +
				'<td onclick="document.list_item_click( event );">' + host_name + '</td>' +
				'<td style="text-align:right;">' + document.object_list_of_hosts[host_name].port + '</td>' +
				'<td>' +
					'<button id="btnEnableHost" class="blue' + btnEnableHost_disabled + '" onclick="document.btnEnableHost_click( event );">' +
						'' + $BTN_ENABLE[$iso_lang] + '' +
					'</button>' +
				'</td>' +
				'<td>' +
					'<button id="btnDisableHost" class="red' + btnDisableHost_disabled + '" onclick="document.btnDisableHost_click( event );">' +
						'' + $BTN_DISABLE[$iso_lang] + '' +
					'</button>' +
				'</td>' +
			'</tr>\n';

		}// END OF for( var host_name in document.object_list_of_hosts )

		$('#tableHostList').html( lines );

	});// END OF $.ajax php/ajax/getHosts.php

}// END OF function refresh_hosts_list().


function refresh_mods_list() {

	// Get mods list.
	$.ajax({
		url: 'php/ajax/getMods.php',
		success: function( json_encoded_mods_list ) {

			var lines = '';

			// Decode json.
			document.object_list_of_mods = eval( "(" + json_encoded_mods_list + ")" );

			for( var mod_name in document.object_list_of_mods ) {

				// Get mod state.
				if( document.object_list_of_mods[mod_name].mod_activated ) {

					btnEnableMod_disabled = ' disabled';
					btnDisableMod_disabled = '';

				} else {

					btnEnableMod_disabled = '';
					btnDisableMod_disabled = ' disabled';

				}

				// Show html.
				lines += '' +
				'<tr>' +
					'<td>' + mod_name + '</td>' +
					'<td>' +
						'<button id="btnEnableMod" class="blue' + btnEnableMod_disabled + '" onclick="document.btnEnableMod_click( event );">' +
							'' + $BTN_ENABLE[$iso_lang] + '' +
						'</button>' +
					'</td>' +
					'<td>' +
						'<button id="btnDisableMod" class="red' + btnDisableMod_disabled + '">' +
							'' + $BTN_DISABLE[$iso_lang] + '' +
						'</button>' +
					'</td>' +
				'</tr>\n';

			}// END OF for( var mod_name in document.object_list_of_mods )

			$('#tableModList').html( lines );

		}
	});// END OF $.ajax php/ajax/getMods.php

}// END OF function refresh_mods_list()


function new_host() {

	var host_created = false, ajax_request, object_returned_data, message;

	// Send new host data.
	ajax_request = $.ajax({
		url: 'php/ajax/newHost.php',
		type: 'POST',
		async: false,
		data: {
			server_name: $('#txtServerName').val(),
			port: $('#txtListen').val(),
			document_root: $('#txtDocumentRoot').val(),
			wsgi_activated: ( $('#btnEnableWSGI.disabled').length != 0 ),
			host_activated: false
		}
	});// END OF $.ajax php/ajax/newHost.php.

// Decode json.

	object_returned_data = eval( "(" + ajax_request.responseText + ")" );


// Static texts.

	message = object_returned_data['message'];

	message = message.replace(
		'HOST_EXISTS',
		$HOST_EXISTS[$iso_lang]
	);

	message = message.replace(
		'NO_DOCUMENT_ROOT',
		$NO_DOCUMENT_ROOT[$iso_lang]
	);

	message = message.replace(
		'NO_LOGS_DIR',
		$NO_LOGS_DIR[$iso_lang]
	);

	message = message.replace(
		'HOST_NOT_CREATED',
		$HOST_NOT_CREATED[$iso_lang]
	);

	message = message.replace(
		'HOST_CREATED',
		$HOST_CREATED[$iso_lang]
	);


// Host data needed.

	message = message.replace(
		'{{SERVER_NAME}}',
		$('#txtServerName').val()
	);

	message = message.replace(
		'{{DOCUMENT_ROOT}}',
		$('#txtDocumentRoot').val()
	);


// Style info.

	if( object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#099',
			'font-weight': 'bold'
		});

		host_created = true;

	} else if( ! object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#900',
			'font-weight': 'bold'
		});

	}

	$('#divMask label.message').html( message );

	return host_created;

}// END OF function new_host().

function delete_host() {

	var host_deleted = false, ajax_request, object_returned_data, message;

	ajax_request = $.ajax({
		url: 'php/ajax/deleteHost.php',
		type: 'POST',
		async: false,
		data: {
			server_name: $('#txtOldServerName').val()
		}
	});// END OF $.ajax php/ajax/deleteHost.php.

// DECODE JSON.

	object_returned_data = eval( "(" + ajax_request.responseText + ")" );


// Static texts.

	message = object_returned_data['message'];

	message = message.replace(
		'HOST_DOES_NOT_EXIST',
		$HOST_DOES_NOT_EXIST[$iso_lang]
	);

	message = message.replace(
		'PORTS_FILE_NO_BACKUP',
		$PORTS_FILE_NO_BACKUP[$iso_lang]
	);

	message = message.replace(
		'PORTS_FILE_CORRUPTED',
		$PORTS_FILE_CORRUPTED[$iso_lang]
	);

	message = message.replace(
		'HOST_NO_BACKUP',
		$HOST_NO_BACKUP[$iso_lang]
	);

	message = message.replace(
		'HOST_STILL_ACTIVATED',
		$HOST_STILL_ACTIVATED[$iso_lang]
	);

	message = message.replace(
		'HOST_DOES_NOT_REMOVED',
		$HOST_DOES_NOT_REMOVED[$iso_lang]
	);

	message = message.replace(
		'HOST_DELETED',
		$HOST_DELETED[$iso_lang]
	);


// Host data needed.

	message = message.replace(
		'{{SERVER_NAME}}',
		$('#txtServerName').val()
	);


// Style info.

	if( object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#099',
			'font-weight': 'bold'
		});

		host_deleted = true;

	} else if( ! object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#900',
			'font-weight': 'bold'
		});

	}

	$('#divMask label.message').html( message );

	return host_deleted;

}// END OF function delete_host().

function edit_host() {

	var host_modified = false, message;

	if($('#txtOldServerName').val() != $('#txtServerName').val()
	&& document.object_list_of_hosts[$('#txtServerName').val()]) {

		message = $HOST_EXISTS[$iso_lang];

	} else {

		if(delete_host()) {

			if(new_host()) {

				host_modified = true;

				// Static text.
				message = $HOST_MODIFIED[$iso_lang];


			// Host data needed.

				message = message.replace(
					'{{OLD_SERVER_NAME}}',
					$('#txtOldServerName').val()
				);

				message = message.replace(
					'{{NEW_SERVER_NAME}}',
					$('#txtServerName').val()
				);


			// Style info.

				if( host_modified ) {

					$('#divMask label.message').css({
						color: '#099',
						'font-weight': 'bold'
					});

				} else if( !host_modified ) {

					$('#divMask label.message').css({
						color: '#900',
						'font-weight': 'bold'
					});

				}

				$('#divMask label.message').html( message );

			}// END OF if(new_host())

		}// END OF if(delete_host())

	}// END OF else -> ($('#txtOldServerName') != $('#txtServerName') && document.object_list_of_hosts[$('#txtServerName')])

	return host_modified;

}// END OF function edit_host().

function enable_host(server_name) {

	var host_enabled = false, ajax_request, object_returned_data, message;

	ajax_request = $.ajax({
		url: 'php/ajax/enableHost.php',
		type: 'POST',
		async: false,
		data: {
			server_name: server_name
		}
	});// END OF $.ajax 'php/ajax/enableHost.php'.

	// Decode JSON.
	object_returned_data = eval( "(" + ajax_request.responseText + ")" );

	// Show command output in the console.
	console.info(
		'a2ensite: ' + object_returned_data['command_output']['return']
	);
	console.info(object_returned_data['command_output']['message']);


// STATIC TEXT.

	message = object_returned_data['message'];

	message = message.replace(
		'PORTS_FILE_NO_BACKUP',
		$PORTS_FILE_NO_BACKUP[$iso_lang]
	);

	message = message.replace(
		'PORTS_FILE_CORRUPTED',
		$PORTS_FILE_CORRUPTED[$iso_lang]
	);

	message = message.replace(
		'HOST_ENABLED',
		$HOST_ENABLED[$iso_lang]
	);


// Host data needed.

	message = message.replace(
		'{{SERVER_NAME}}',
		server_name
	);


// Style info.

	if( object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#099',
			'font-weight': 'bold'
		});

		host_enabled = true;

	} else {

		$('#divMask label.message').css({
			color: '#900',
			'font-weight': 'bold'
		});

	}

	$('#divMask label.message').html( message );


	return host_enabled;

}// END OF function enable_host(server_name).


function disable_host(server_name) {

	var host_disabled = false, ajax_request, object_returned_data, message;

	ajax_request = $.ajax({
		url: 'php/ajax/disableHost.php',
		type: 'POST',
		async: false,
		data: {
			server_name: server_name
		}
	});// END OF $.ajax 'php/ajax/disableHost.php'.

	// Decode JSON.
	object_returned_data = eval( "(" + ajax_request.responseText + ")" );

	// Show command output in the console.
	console.info(
		'a2dissite: ' +	object_returned_data['command_output']['return']
	);
	console.info(object_returned_data['command_output']['message']);


// STATIC TEXT.

	message = object_returned_data['message'];

	message = message.replace(
		'PORTS_FILE_NO_BACKUP',
		$PORTS_FILE_NO_BACKUP[$iso_lang]
	);

	message = message.replace(
		'PORTS_FILE_CORRUPTED',
		$PORTS_FILE_CORRUPTED[$iso_lang]
	);

	message = message.replace(
		'HOST_DISABLED',
		$HOST_DISABLED[$iso_lang]
	);


// Host data needed.

	message = message.replace(
		'{{SERVER_NAME}}',
		server_name
	);


// Style info.

	if( object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#099',
			'font-weight': 'bold'
		});

		host_disabled = true;

	} else {

		$('#divMask label.message').css({
			color: '#900',
			'font-weight': 'bold'
		});

	}

	$('#divMask label.message').html( message );


	return host_disabled;

}// END OF function disable_host(server_name).


function enable_mod(mod_name) {

	var mod_enabled = false, ajax_request, object_returned_data, message;

	ajax_request = $.ajax({
		url: 'php/ajax/enableMod.php',
		type: 'POST',
		async: false,
		data: {
			mod_name: mod_name
		}
	});// END OF $.ajax 'php/ajax/enableMod.php'.

	// Decode JSON.
	object_returned_data = eval( "(" + ajax_request.responseText + ")" );

	// Show command output in the console.
	console.info(
		'a2enmod: ' + object_returned_data['command_output']['return']
	);
	console.info(object_returned_data['command_output']['message']);


// STATIC TEXT.

	message = object_returned_data['message'];

	message = message.replace(
		'MOD_NOT_ENABLED',
		$MOD_NOT_ENABLED[$iso_lang]
	);

	message = message.replace(
		'MOD_ENABLED',
		$MOD_ENABLED[$iso_lang]
	);


// Host data needed.

	message = message.replace(
		'{{MOD_NAME}}',
		mod_name
	);


// Style info.

	if( object_returned_data['return'] ) {

		$('#divMask label.message').css({
			color: '#099',
			'font-weight': 'bold'
		});

		mod_enabled = true;

	} else {

		$('#divMask label.message').css({
			color: '#900',
			'font-weight': 'bold'
		});

	}

	$('#divMask label.message').html( message );


	return mod_enabled;

}// END OF function enable_mod(mod_name)

