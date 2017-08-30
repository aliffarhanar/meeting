<?php
if (!isset($_GET['image'])) exit;
header("Content-Type: image/jpeg");
$token = isset($_SESSION['token'])?'?access_token='.$_SESSION['token']:'?access_token=YWMth7NWoIyKEeeawVtwS-nvygAAAV5Q6WW-e_lJ57Xo8KIv_Q2M7TER0SZQVW4';
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.nobackend.id/nobackend.meeting/meeting/ruangans/".$_GET['image'].$token,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
	"accept: image/jpeg",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
