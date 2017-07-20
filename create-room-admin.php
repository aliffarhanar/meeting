<?php

if (isset($_POST)) {
	function upload_foto($name) {
		$curl = curl_init();
		$filename = basename($_FILES["foto"]["name"]);
		$contentType = $_FILES["foto"]["type"];
		$tmpfile = $_FILES['foto']['tmp_name'];
		$file = curl_file_create($tmpfile, $contentType, $filename);
		$post = array('file' =>  $file);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.nobackend.id/tbaas.rapatin/meeting/ruangans/".$name,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_POSTFIELDS => $post,
		  CURLOPT_HTTPHEADER => array("Content-Type: multipart/form-data"),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return false;
		} else {
		  return true;
		}
	}
	include_once "inc/config.php";
	$body = array(
		"name" => $_POST['gedung'],
		"name" => $_POST['name'],
		"address" => $_POST['address'],
		"capacity" => $_POST['capacity'],
		"facility" => $_POST['facility'],
	);
	$endpoint = 'ruangans';
	$query_string = array();
	$result = $client->post($endpoint, $query_string, $body);
	upload_foto($_POST['name']);
	if ($result->get_error() && !upload_foto($_POST['name'])){
		header("location:?page=find-room");
	} else {
		header("location:?page=find-room");
	}
	
}