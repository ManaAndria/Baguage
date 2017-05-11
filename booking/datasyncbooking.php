<?php
/*
Plugin Name: datasyncbooking
Plugin URI: 
Description: 
Author: Netunivers
Author URI: 
License: GPLv2 or later
Text Domain: datasyncbooking
*/

// ajout option pour stocker le token
if (!get_option('dsb_access_token')) {
	add_option('dsb_access_token');
}

// ajout option pour stocker le token
if (!get_option('dsb_refresh_token')) {
	add_option('dsb_refresh_token');
}

//shortcode pour l'affichage du résultat de la recherche
function booking_search_result( $atts ) {
	$output = '';
	// recherche sur bookingsync après validation du formulaire de recherche et affichage de la liste des villas
	if (isset($_POST['form']) && isset($_POST['form']['dateDebut']) && isset($_POST['form']['dateFin'])) {
		$from = $_POST['form']['dateDebut'];
		$until = $_POST['form']['dateFin']);
		$all_rentals = getRentals();
		if (!$all_rentals) {
			$token = refreshToken();
			$all_rentals = getRentals($token);
		}
		$unavailables = getAvailableRentals($from, $until);
		$availables = array();
		foreach ($all_rentals as $all_rental) {
			if (!in_array($all_rental, $unavailables)) {
				$availables[] = $all_rental;
			}
		}

		
		
	} else { // afficher message par défaut si ne vient pas du formulaire de recherche

	}
	return $output;
}
add_shortcode( 'dbs_search_result', 'booking_search_result' );

// get all rentals
function getRentals($token = null) {
	if ($token === null) {
		$token = "b5ca13b31d134cbf534112bf5bab786f5c71bee04048dc99cbdcc9b240bb240d";
	} else {
		$refresh = get_option('dsb_access_token');
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token", "Content-Type: application/json", "Accept: application/json"));
	curl_setopt($ch, CURLOPT_URL, "https://www.bookingsync.com/api/v3/rentals");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);

	$response_arr = json_decode($response);
	if (isset($response_arr->errors))
		return false;
	$rentals = $response_arr->rentals;
	$all_rentals = array();
	foreach ($rentals as $rental) {
		$all_rentals[] = $rental->id;
	}
	return $all_rentals;
}

// refresh token when expired
function refreshToken($refresh = null) {
	if ($refresh === null) {
		$refresh = "7fa5f6fe89566b79304969a469a4df05e530975fd3bc63cfe29fd72c198eb68e";
	} else {
		$refresh = get_option('dsb_refresh_token');
	}
	$ch = curl_init();
	$data = array
	(
	  "client_id" => "e248015a15608834c3a39c5eac6c6ba4db86334d1b38a85583f46980859949ee",
	  "client_secret" => "b7d449295120bb212bbbc262b763f04ef44aa7a95187593ef031a919071d329e",
	  "refresh_token" => $refresh,
	  "grant_type" => "refresh_token",
	  "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob"
	);
	$data_string = json_encode($data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer cOkustgdj7MmKEQBAjBUK0no9EOs", "Content-Type: application/json", "Accept: application/json"));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_URL, "https://www.bookingsync.com/oauth/token");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);
	$response_arr = json_decode($response);
	update_option('dsb_access_token', $response_arr['access_token']);
	update_option('dsb_refresh_token', $response_arr['refresh_token']);
	return $response_arr['access_token'];
}

function getAvailableRentals($from, $until) {
	$ch3 = curl_init();
	curl_setopt($ch3, CURLOPT_HTTPHEADER, array("Authorization: Bearer b5ca13b31d134cbf534112bf5bab786f5c71bee04048dc99cbdcc9b240bb240d", "Content-Type: application/json", "Accept: application/json"));
	curl_setopt($ch3, CURLOPT_URL, "https://www.bookingsync.com/api/v3/bookings?status=booked,unavailable&from=$from&until=$until");
	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

	$response3 = curl_exec($ch3);
	curl_close($ch3);
	$response_arr3 = json_decode($response3);
	$results = $response_arr3->bookings;

	$unavailables = array();
	foreach ($results as $result) {
		$unavailables[] = $result->rental;
	}

	return $unavailables;
}
