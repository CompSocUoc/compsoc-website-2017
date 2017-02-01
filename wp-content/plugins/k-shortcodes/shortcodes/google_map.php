<?php
/**
 * Shortcode google map.
 *
 * @since  1.0
 * @author LunarTheme
 * @link   http://www.lunartheme.com
 */

if ( ! function_exists( 'k2t_google_map_shortcode' ) ) {
	function k2t_google_map_shortcode( $args, $content=NULL ) {
		$html = $lat = $lon = $z = $w = $h = $maptype = $mapstype = $address = $marker = $markerimage = $traffic = $draggable = $infowindow = $infowindowdefault = $hidecontrols = $scrollwheel = $color = $id = $class = '';
		extract( shortcode_atts( array(
			'lat'               => '0',
			'lon'               => '0',
			'id'                => '',
			'z'                 => '1',
			'w'                 => '600',
			'h'                 => '400',
			'maptype'           => 'ROADMAP',
			'mapstype'			=> '',
			'address'           => '',
			'marker'            => 'no',
			'markerimage'       => '',
			'traffic'           => 'no',
			'draggable'         => 'false',
			'infowindow'        => '',
			'infowindowdefault' => 'yes',
			'hidecontrols'      => 'false',
			'scrollwheel'       => 'false',
			'color'             => '',
			'class'             => '',
		), $args ) );

		wp_enqueue_script( 'k2t-google-map' );

		$id    = ( !empty( $id ) ) ? $id : 'map_'.rand();

		$w = is_numeric( $w ) ? 'width:'. $w .'px;' : 'width:'. $w .';';
		$h = is_numeric( $h ) ? 'height:'. $h .'px;' : 'height:'. $h .';';
		$gmap = '<div class="' . $class . '" id="k2t_' . $id . '" style="' . $w . $h . '"></div>';

		$gmap .= '<script>
		(function($) {
		"use strict";
		$(document).ready(function() {
		var latlng = new google.maps.LatLng(' . $lat . ', ' . $lon . ');
		var myOptions = {
			zoom: ' . $z . ',
			center: latlng,
			mapTypeId: google.maps.MapTypeId.' . $maptype . ',';
			
		if ( $scrollwheel == 'true' ) {
			$gmap .= 'scrollwheel: true,';
		}else{
			$gmap .= 'scrollwheel: false,';
		}
		if ( !empty( $hidecontrols ) ) {
			$gmap .= 'disableDefaultUI: "' . $hidecontrols . '",';
		}
		if ( $draggable == 'true' ) {
			$gmap .= 'draggable: true,';
		}else{
			$gmap .= 'draggable: false,';
		}
		if ( !empty( $color ) ) {
			$gmap .= 'backgroundColor: "' . $color . '",';
		}
		switch ( $mapstype ) {
			case 'grayscale':
				$gmap .= 'styles: [{"featureType": "landscape","stylers": [{"saturation": -100},{"lightness": 65},{"visibility": "on"}]},
					{"featureType": "poi","stylers": [{"saturation": -100},{"lightness": 51},{"visibility": "simplified"}]},
					{"featureType": "road.highway","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "road.arterial","stylers": [{"saturation": -100},{"lightness": 30},{"visibility": "on"}]},
					{"featureType": "road.local","stylers": [{"saturation": -100},{"lightness": 40},{"visibility": "on"}]},
					{"featureType": "transit","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "administrative.province","stylers": [{"visibility": "off"}]},
					{"featureType": "water","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": -25},{"saturation": -100}]},
					{"featureType": "water","elementType": "geometry","stylers": [{"hue": "#ffff00"},{"lightness": -25},{"saturation": -97}]
				}]';
				break;
			case 'blue_water':
				$gmap .= 'styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{}]},
					{"featureType":"landscape","elementType":"all","stylers":[{}]},
					{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"road","elementType":"all","stylers":[]},
					{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"on"}]},
					{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"water","elementType":"all","stylers":[{"color":"#afe0ff"},{"visibility":"on"}]
				}]';
				break;
			case 'pale_dawn':
				$gmap .= 'styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},
					{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},
					{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},
					{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},
					{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},
					{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},
					{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]
				}]';
				break;
			case 'shades_of_grey':
				$gmap .= 'styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},
					{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},
					{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
					{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},
					{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
					{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},
					{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},
					{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},
					{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]
				}]';
				break;

			default:
				# code...
				break;
		}
		$gmap .= '};
		var ' . $id . ' = new google.maps.Map(document.getElementById("k2t_' . $id . '"), myOptions);';
		//traffic
		if ( $traffic == 'true' ) {
			$gmap .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $id . ');
			';
		}
		//address
		if ( !empty( $address ) ) {
			$gmap .= 'var geocoder_' . $id . ' = new google.maps.Geocoder();
			var address = \'' . $address . '\';
			geocoder_' . $id . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $id . '.setCenter(results[0].geometry.location);';

			if ( $marker == 'true' ) {
				//add custom image
				if ( !empty( $markerimage ) && is_numeric( $markerimage ) ){
					$gmap .= 'var image = "'. wp_get_attachment_url( $markerimage ) .'";';
				}elseif( !empty( $markerimage ) ){
					$gmap .= 'var image = "'. $markerimage .'";';
				}
				$gmap .= '
						var marker = new google.maps.Marker({
							map: ' . $id . ',
							';
				if ( !empty( $markerimage ) ) {
					$gmap .= 'icon: image,';
				}
				$gmap .= 'position: ' . $id . '.getCenter()});';
				//infowindow
				if ( !empty( $infowindow ) ) {
					//first convert and decode html chars
					$thiscontent = htmlspecialchars_decode( $infowindow );
					$gmap .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $id . ',marker);});';
					//infowindow default
					if ( $infowindowdefault == 'true' ) {
						$gmap .= '
									infowindow.open(' . $id . ',marker);
								';
					}
				}
			}
			$gmap .= '} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
		}

		//marker: show if address is not specified
		if ( $marker == 'true' && empty( $address ) ) { 
			//add custom image
			if ( !empty( $markerimage ) && is_numeric( $markerimage ) ){
				$gmap .= 'var image = "'. wp_get_attachment_url( $markerimage ) .'";';
			}elseif( !empty( $markerimage ) ){
				$gmap .= 'var image = "'. $markerimage .'";';
			}

			$gmap .= '
				var marker = new google.maps.Marker({
				map: ' . $id . ',
				';
			if ( !empty( $markerimage ) ) {
				$gmap .= 'icon: image,';
			}
			$gmap .= 'position: ' . $id . '.getCenter()});';

			//infowindow
			if ( !empty( $infowindow ) ) {
				$gmap .= '
				var contentString = \'' . $infowindow . '\';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $id . ',marker);
				});
				';
				//infowindow default
				if ( $infowindowdefault == 'true' ) {
					$gmap .= '
						infowindow.open(' . $id . ',marker);
					';
				}
			}
		}

		$gmap .= '});})(jQuery);</script>';

		//Apply filters return
		$gmap = apply_filters( 'k2t_google_map_return', $gmap );

		return $gmap;
	}
}
