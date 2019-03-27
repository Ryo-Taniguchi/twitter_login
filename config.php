<?php

ini_set('display_errors', 1);

// twitterouth読み込み
require_once(__DIR__ . '/vendor/autoload.php');

// Twitter API
define('API_KEY', 'axKhJSdhoofoYrdTigaqrEeGb');
define('API_SECRET', 'H1EbC14Xe3M7Uwm9ej7NGa06Z6WUhJzsduRsWoG39emKrT4OUO');
define('CALLBACK_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/login.php');

define('DSN', 'mysql:host=localhost;dbname=twitter_login');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', '$yaniguti');

session_start();

require_once(__DIR__ . '/functions.php');
// Classの読み込みを効率化
require_once(__DIR__ . '/autoload.php');
