<?php

require_once(__DIR__ . '/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  try {
    MyApp\Token::validate('token');
  } catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }
  //　セッション空にする
  $_SESSION = [];

  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
  }

  session_destroy();
}

header('Location: http://' . $_SERVER['HTTP_HOST']);
