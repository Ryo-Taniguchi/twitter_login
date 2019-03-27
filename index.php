<?php

require_once(__DIR__ . '/config.php');

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Twitter Connect!</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <style>
  #container {
    width: 500px;
    margin: 0 auto;
    padding-top: 20px;
  }

  h1 {
    font-size: 18px;
    padding: 3px 0;
  }
  #login {
    text-align: center;
  }
  </style>
</head>
<body>
  <div id="container">
    <div id="login">
      <a href="login.php"><i class="fab fa-twitter fa-5x"></i></a>
    <h1 id="twitter">Twitterでログインしてね</h1>
    </div>
  </div>
</body>
</html>
