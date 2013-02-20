// ON READY.
$(document).ready(function() {

	$('#sectionInstall, #sectionUserManual, #sectionContribute').hide(0);


// EVENTS.

	$('#aHome').click(function(e) {

		e.preventDefault();

		$('#sectionInstall, #sectionUserManual, #sectionContribute').fadeOut(
			0,
			function() {

				$('#sectionHome').fadeIn(0);

			}

		);

	});


	$('#aInstall, #aInstallIt').click(function(e) {

		e.preventDefault();

		$('#sectionHome, #sectionUserManual, #sectionContribute').fadeOut(
			0,
			function() {

				$('#sectionInstall').fadeIn(0);

			}

		);

	});
	$('#aInstallIt').click(function(e) {

		e.preventDefault();

		window.scrollTo(0,0);

	});


	$('#aUserManual, #aUseIt').click(function(e) {

		e.preventDefault();

		$('#sectionHome, #sectionInstall, #sectionContribute').fadeOut(
			0,
			function() {

				$('#sectionUserManual').fadeIn(0);

			}

		);

	});
	$('#aUseit').click(function(e) {

		e.preventDefault();

		window.scrollTo(0,0);

	});

});

