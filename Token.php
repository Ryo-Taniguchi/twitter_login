<?php

namespace MyApp;

  class Token {

    static public function create() {
      if (!isset($_SESSION['token'])) {
        // 32ケタの推測されにくい文字列生成
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
      }
    }

    static public function validate($tokenkey) {
      if (!isset($_SESSION['token']) ||
          !isset($_POST[$tokenkey]) ||
          $_SESSION['token'] !== $_POST[$tokenkey]
      ) {
        var_dump($_SESSION['token']);
        var_dump($_POST[$tokenkey]);
        throw new \Exception('invalid token!');
      }
      }
  }
