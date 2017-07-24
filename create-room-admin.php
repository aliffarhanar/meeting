<?php
if ($_GET['delete']) {
	include_once "inc/config.php";
	$endpoint = 'ruangans/'.$_GET['delete'];
	$query_string = array();
	$result =  $client->delete($endpoint, $query_string);
	session_start();
	if ($result->get_error() ){
		$_SESSION['notif'] = "<br>
							<div class='row'>
								<div class='col-md-12'>
									<div class='alert alert-danger' style='text-align:center;margin-bottom: 0px;'>
										<h4>Gagal Menghapus ruangan.</h4> 
									</div>
								</div>
							</div>";
		header("location:index.php?page=find-room");
	} else {
		$_SESSION['notif'] = "<br>
			<div class='row'>
				<div class='col-md-12'>
					<div class='alert alert-success' style='text-align:center;margin-bottom: 0px;'>
						<h4>Ruangan berhasil dihapus.</h4> 
					</div>
				</div>
			</div>";
		header("location:index.php?page=find-room");
	}
}

if (isset($_POST['create-room'])) {
	include_once "inc/config.php";
	function upload_foto($name) {
		$curl = curl_init();
		$filename = basename($_FILES["foto"]["name"]);
		$contentType = $_FILES["foto"]["type"];
		$tmpfile = $_FILES['foto']['tmp_name'];
		$file = curl_file_create($tmpfile, $contentType, $filename);
		$post = array('file' =>  $file);
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.nobackend.id/nobackend.meeting/meeting/ruangans/".$name,
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
	$body = array(
		"name" => $_POST['name'],
		"gedung" => $_POST['gedung'],
		"address" => $_POST['address'],
		"capacity" => $_POST['capacity'],
		"facility" => $_POST['facility'],
	);
	$endpoint = 'ruangans';
	$query_string = array();
	$result = $client->post($endpoint, $query_string, $body);
	session_start();
	if ($result->get_error() ){
		$_SESSION['notif'] = "<br>
							<div class='row'>
								<div class='col-md-12'>
									<div class='alert alert-danger' style='text-align:center;margin-bottom: 0px;'>
										<h4>Gagal melakukan input.</h4> 
									</div>
								</div>
							</div>";
		header("location:index.php?page=find-room");
	} elseif (!upload_foto($_POST['name'])) {
		$_SESSION['notif'] = "<br>
					<div class='row'>
						<div class='col-md-12'>
							<div class='alert alert-danger' style='text-align:center;margin-bottom: 0px;'>
								<h4>Gagal melakukan upload foto.</h4> 
							</div>
						</div>
					</div>";
		header("location:index.php?page=find-room");
	} else {
		$_SESSION['notif'] = "<br>
			<div class='row'>
				<div class='col-md-12'>
					<div class='alert alert-success' style='text-align:center;margin-bottom: 0px;'>
						<h4>Ruangan berhasil ditambahkan</h4> 
					</div>
				</div>
			</div>";
		header("location:index.php?page=find-room");
	}
	
}