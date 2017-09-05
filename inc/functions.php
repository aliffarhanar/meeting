<?php

function login_helio() {
    $curl = curl_init();
    $post = array('username' =>  'info', 'password' => 'nobackend2017', 'domains' => 'nobackend.id');
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.helio.id/apilogin",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $post,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return json_decode($response,true);
    }
}

function message_helio($token,$to,$subject,$body) {
    $curl = curl_init();
    $post = array('token' =>  $token, 'to' => $to, 'subject' => $subject, 'body' => $body);
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.helio.id/composemobile",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $post,
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return $response;
    }
}
