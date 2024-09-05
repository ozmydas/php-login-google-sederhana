<?php

require_once('load_env.php');

// klo gak ada yg dikirm
if(empty($_POST)):
    http_response_code(400);
    exit("No Valid Response from Provider.");
endif;

// ambil header termasuk cookie
$headers = getallheaders();

foreach ($headers as $key => $value) {
    // echo "$key: $value\n";
}

// ambil token
$csrf_token_body = @$_REQUEST['g_csrf_token'];
$credential_token = @$_REQUEST['credential'];

// ambil cookie yg diperlukan
$cookie = $headers['Cookie'];
$cookies = explode("; ", $cookie);
$array_cookies = [];

foreach ($cookies as $key => $value) {
    $keyval = explode("=", $value);
    $array_cookies[$keyval[0]] = $keyval[1];
}

$csrf_token_cookie = @$array_cookies['g_csrf_token'];

// validasi csrf
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

// validasi token yang diterima untuk diambil informasi user data
$client = new Google_Client(['client_id' => $CLIENT_ID]);
$payload = $client->verifyIdToken($credential_token);
if ($payload) {
    // print_r($payload);

    // simpan session dan redirect ke halaman profil (ceritanya)
    $_SESSION['userdata'] = $payload;
    header("Location: $WEB_URL");
    die();
} else {
    http_response_code(400);
    exit("Invalid Response Code.");
}
