<?php

// Classが出てきた時の処理
spl_autoload_register(function($class){
  // 名前空間をMyAppにする,'\'を\でエスケープ
  $prefix = 'MyApp\\';

  // もし引数にMyAppがあり、0から始まる場合
  if (strpos($class, $prefix) === 0) {
    // $prefixの文字列の長さ分取り除く
    $className = substr($class, strlen($prefix));
    // クラスファイルのあるパスを取得
    $classFilePath = __DIR__ . '/' . $className . '.php';
    if (file_exists($classFilePath)) {
      require $classFilePath;
    } else {
      echo 'No such class: ' . $className;
      exit;
    }
  }
});
