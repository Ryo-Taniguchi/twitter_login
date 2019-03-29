<?php

require_once(__DIR__ . '/config.php');

$twitterLogin = new MyApp\TwitterLogin();

if($twitterLogin->isLoggedIn()) {
  $me = $_SESSION['me'];
  // Twitterから情報を引っ張るためにコンストラクタの引数にアクセストークンを渡す
  $twitter = new MyApp\Twitter($me->tw_access_token, $me->tw_access_token_secret);
  $tweets = $twitter->getTweets();

  MyApp\Token::create();
}

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

  #logout {
    float: right;
  }
  </style>
</head>
<body>
  <div id="container">
    <?php if($twitterLogin->isLoggedIn()) : ?>
      <div id="login">
        <i class="fab fa-twitter fa-5x"></i>
        <form action="logout.php" method="post" id="logout">
          <input type="submit" value="Log Out">
          <input type="hidden" name="token" value="<?= h($_SESSION['token']);  ?>">
        </form>
      <h1 id="twitter">@<?= h($me->tw_screen_name); ?>だよ！!</h1>
      <ul>
        <?php foreach ($tweets as $tweet) : ?>
          <li><?= $tweet->text; ?></li>
        <?php endforeach ; ?>
      </ul>
      </div>
    <?php else: ?>
      <div id="login">
        <a href="login.php"><i class="fab fa-twitter fa-5x"></i></a>
      <h1 id="twitter">Twitterでログインしてね</h1>
      </div>
    <?php endif ; ?>
  </div>
</body>
</html>
