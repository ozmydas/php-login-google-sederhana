<?php 

require_once('load_env.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  session_destroy();

  $_SESSION['userdata'] = null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hello World</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .container {
      text-align: center;
    }

    .signin-container {
      background: transparent;
    }

    .logout {
      background: tomato;
      color: #fff;
      border: 0px;
      padding: 7px 20px;
      cursor: pointer;
      border-radius: 4px;
      transition: all .2s linear;
    }

    .logout:hover {
      transform: scale(1.2);
    }

    .userdata {
      background: rgba(0, 0, 0, .1);
      max-width: 600px;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 40px;
    }
  </style>
</head>

<body>
  <script src="https://accounts.google.com/gsi/client" async></script>

  <div class="container">
    <h1>Hello, World!</h1>

    <div class="signin-container">
      <?php if (empty($_SESSION['userdata'])): ?>

        <div id="g_id_onload" data-client_id="<?=$CLIENT_ID ?>"
          data-login_uri="<?=$WEB_URL?>/callback.php" data-auto_prompt="false"></div>
        <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="sign_in_with"
          data-shape="rectangular" data-logo_alignment="left"></div>

      <?php else: ?>
        <div class="userdata">
          <?php print_r($_SESSION['userdata']); ?>
        </div>

        <form id="logout-form" action="" method="POST">
          <button class="logout">Logout</button>
        </form>

      <?php endif; ?>
    </div>
  </div>
</body>

</html>
