
<?php 
// get tokken

function getToken () {
	$ch = curl_init();
	$data = array
	(
	  "client_id" => "e248015a15608834c3a39c5eac6c6ba4db86334d1b38a85583f46980859949ee",
	  "client_secret" => "b7d449295120bb212bbbc262b763f04ef44aa7a95187593ef031a919071d329e",
	  "code" => "f05a35de00c7c22dea6ad951db8b444c3ec4414a89fda017b8a616a990e05054",
	  "grant_type" => "authorization_code",
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
	var_dump($response);
}
// refresh token
function refreshToken () {
	$ch = curl_init();
	$data = array
	(
	  "client_id" => "e248015a15608834c3a39c5eac6c6ba4db86334d1b38a85583f46980859949ee",
	  "client_secret" => "b7d449295120bb212bbbc262b763f04ef44aa7a95187593ef031a919071d329e",
	  "refresh_token" => "7fa5f6fe89566b79304969a469a4df05e530975fd3bc63cfe29fd72c198eb68e",
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
	var_dump($response);
}
// refreshToken();

/*
//
// requête pour avoir la liste de toutes les villas
//
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer b5ca13b31d134cbf534112bf5bab786f5c71bee04048dc99cbdcc9b240bb240d", "Content-Type: application/json", "Accept: application/json"));
curl_setopt($ch, CURLOPT_URL, "https://www.bookingsync.com/api/v3/rentals");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);
$response_arr = json_decode($response);
print_r(isset($response_arr->errors));
$rentals = $response_arr->rentals;
$all_rentals = array();
foreach ($rentals as $rental) {
	$all_rentals[] = $rental->id;
}
print_r($all_rentals);
/*
$url2 = "https://www.bookingsync.com/api/v3/availabilities/$availability_id";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Authorization: Bearer 4df858495f49a03425cccdade85e49cc8db211f291a7f6e0038a04c1448a74ed", "Content-Type: application/json", "Accept: application/json"));
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

$response2 = curl_exec($ch2);
curl_close($ch2);
$response_arr2 = json_decode($response2);
print_r($response_arr2);
*/

/*

//
// requête pour avoir la liste des villas non disponibles entre les dates données 
// filtrer les villas qui ne sont pas dans la liste des villas non disponibles pour avoir la liste des villas disponibles
//
$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_HTTPHEADER, array("Authorization: Bearer 4df858495f49a03425cccdade85e49cc8db211f291a7f6e0038a04c1448a74ed", "Content-Type: application/json", "Accept: application/json"));
curl_setopt($ch3, CURLOPT_URL, "https://www.bookingsync.com/api/v3/bookings?status=booked,unavailable&from=20170506&until=20170507");
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

$response3 = curl_exec($ch3);
curl_close($ch3);
$response_arr3 = json_decode($response3);
$results = $response_arr3->bookings;

var_dump($results);exit;
$unavailables = array();
foreach ($results as $result) {
	$unavailables[] = $result->rental;
}

$availables = array();
foreach ($all_rentals as $all_rental) {
	if (!in_array($all_rental, $unavailables)) {
		$availables[] = $all_rental;
	}
}
print_r($availables);
?>
