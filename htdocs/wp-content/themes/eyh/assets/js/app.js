/**
 *
 * Toggle Google map markers and show or hide data from highschools.
 *
 */
( function() {

	// Data array comes from functions.php.
	var locations = JSON.parse( EyhMap.locations );

	// Init the map and hard coded location.
	var map = new google.maps.Map( document.getElementById( 'map' ), {
		zoom: 11,
		center: new google.maps.LatLng(60.205160, 24.676797),
	});

	// Add variables needed later.
	var infowindow = new google.maps.InfoWindow();
	var marker, i;
	var markers1 = [];

	// Loop all the locations and add marker with info on click.
	for ( i = 0; i < locations.length; i++ ) {
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng( locations[i][2], locations[i][3] ),
			map: map,
		});

		// Show info window on click.
		google.maps.event.addListener( marker, 'click', ( function( marker, i ) {
			return function() {
				infowindow.setContent( locations[i][1] );
				infowindow.open( map, marker );
			}
		})( marker, i ) );

		// Hide all markers at first.
		marker.setMap( null );

		// Add markers in array.
		markers1.push( marker );
	} // End for.

	// Show marker on click.
	function showMarker( id ) {
		for ( var i = 0; i < locations.length; i++ ) {
			if ( locations[i][0] == id ) {
				markers1[i].setMap( map );
			}
		}
	}

	// Hide marker on click.
	function hideMarker( id ) {
		for ( var i = 0; i < locations.length; i++ ) {
			if ( locations[i][0] == id ) {
				markers1[i].setMap( null );
			}
		}
	}

	// Select "highschool" buttons.
	var schoolButtons = document.querySelectorAll( '.select-highschool' );

	// For each column button element add click event.
	schoolButtons.forEach( function( el ) {
		// Get correct ID from 'data-select' attribute.
		var schoolIdAttr = el.getAttribute( 'data-select' );
		var schoolId     = document.getElementById( schoolIdAttr );

		// On click add/remove classes and markers.
		el.addEventListener( 'click', function () {

			if ( -1 !== el.className.indexOf( 'selected' ) ) {
				el.className = el.className.replace( ' selected', '' );
				schoolId.className = schoolId.className.replace( ' selected', '' );
				hideMarker( schoolIdAttr );
			} else {
				el.className += ' selected';
				schoolId.className += ' selected';
				showMarker( schoolIdAttr );
			}

		});
	}); // End forEach.

	// Select "column" buttons.
	var columnButtons = document.querySelectorAll( '.select-col' );

	// For each column button element add click event.
	columnButtons.forEach( function( el ) {
		// Get correct class from 'data-col' attribute.
		var colClassAttr = el.getAttribute( 'data-col' );
		var colClass     = document.getElementsByClassName( colClassAttr );

		// On click add/remove classes.
		el.addEventListener( 'click', function () {

			if ( -1 !== el.className.indexOf( 'selected' ) ) {
				el.className = el.className.replace( ' selected', '' );
				for ( var i = 0; i < colClass.length; i++ ) {
					colClass[i].className = colClass[i].className.replace( ' selected', '' );
				}
			} else {
				el.className += ' selected';
				for ( var i = 0; i < colClass.length; i++ ) {
					colClass[i].className += ' selected';
				}
			}

		});
	}); // End forEach.

} )();
