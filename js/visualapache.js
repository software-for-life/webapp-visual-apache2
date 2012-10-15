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

$(document).ready(function(){

// ON READY DO

	// Hide modules section.
	$("#sectionMods").fadeOut(0);

	// Get hosts list.
	$.ajax({

		url: "php/ajax/getHosts.php"

	}).done(function( json_encoded_hosts_list ) {

		var lines = '';

		var object_hosts_list = eval( "(" + json_encoded_hosts_list + ")" );

		for( var host_name in object_hosts_list ) {

			if( object_hosts_list[host_name].host_activated ) {

				btnEnableHost_disabled = ' disabled';
				btnDisableHost_disabled = '';

			} else {

				btnEnableHost_disabled = '';
				btnDisableHost_disabled = ' disabled';

			}

			lines += '' +
			'<tr>' +
				'<td>' + host_name + '</td>' +
				'<td style="text-align:right;">' + object_hosts_list[host_name].port + '</td>' +
				'<td>' +
					'<button id="btnEnableHost" class="blue' + btnEnableHost_disabled + '">' +
						'' + $BTN_ENABLE[$iso_lang] + '' +
					'</button>' +
				'</td>' +
				'<td>' +
					'<button id="btnDisableHost" class="red' + btnDisableHost_disabled + '">' +
						'' + $BTN_DISABLE[$iso_lang] + '' +
					'</button>' +
				'</td>' +
			'</tr>\n';

		}// END OF for( var host_name in object_hosts_list )

		$('#tableHostList').html( lines );

	});// END OF .done(function( json_encoded_hosts_list )



// EVENTS

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

});

