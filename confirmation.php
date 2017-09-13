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
  var_dump($result);
  if ($result->get_error()){
    echo "Terjadi Kesalahan.";
  } else {
    $_SESSION['login_user'] = "login";
    $_SESSION['name'] = $user->get('name');
    $_SESSION['role'] = $user->get('role');
    $_SESSION['username'] =$user->get('username');
    $_SESSION['password'] = $user->get('password');
    $_SESSION['phone'] = $user->get('phone');
    $_SESSION['email'] = $user->get('email');
    $_SESSION['pic'] = $user->get('pic');
    $_SESSION['token'] = $token;
  }
}
<meta http-equiv="refresh" content="0; url='http://meetingrooms.apps.playcourt.id/login.php'" />
