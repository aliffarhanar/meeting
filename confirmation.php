<?php
if(!isset($_GET['activation_code'])){
  header("location:login.php");
}
include_once "inc/config.php";

$activation_code = $_GET['activation_code'];
$data = array('ql' => "select * where activation_code=".$activation_code);
$users = $client->get_collection('users', $data);
$user = $users->get_next_entity();

if ($activation_code == $user->get('activation_code')) {
  $body = array(
    "approved" => true,
  );
  $endpoint = 'users/'.$user->get('username');
  $query_string = array();
  $result = $client->put($endpoint, $query_string, $body);
  if ($result->get_error()){
    echo "Terjadi Kesalahan.";
  } else {
    header("location:login.php");
  }
}
