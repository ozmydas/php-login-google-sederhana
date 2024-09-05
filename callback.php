<?php

require_once('load_env.php');

if(empty($_POST)):
    http_response_code(400);
    exit("No Valid Response from Provider.");
endif;

$headers = getallheaders();

foreach ($headers as $key => $value) {
    // echo "$key: $value\n";
}

// ambil token
$csrf_token_body = @$_REQUEST['g_csrf_token'];
$credential_token = @$_REQUEST['credential'];

$cookie = $headers['Cookie'];
$cookies = explode("; ", $cookie);
$array_cookies = [];

foreach ($cookies as $key => $value) {
    $keyval = explode("=", $value);
    $array_cookies[$keyval[0]] = $keyval[1];
}

// var_dump($array_cookies);


$csrf_token_cookie = @$array_cookies['g_csrf_token'];

if (empty($csrf_token_cookie)):
    http_response_code(400);
    exit("No CSRF token in Cookie.");
elseif (empty($csrf_token_body)):
    http_response_code(400);
    exit("No CSRF token in post body.");
elseif ($csrf_token_cookie !== $csrf_token_body):
    http_response_code(400);
    exit("Failed to verify double submit cookie.");
endif;

/*********************************************************************************/

$client = new Google_Client(['client_id' => $CLIENT_ID]);
$payload = $client->verifyIdToken($credential_token);
if ($payload) {
    // print_r($payload);
    $_SESSION['userdata'] = $payload;
    header("Location: $WEB_URL");
    die();
} else {
    http_response_code(400);
    exit("Invalid Response Code.");
}
