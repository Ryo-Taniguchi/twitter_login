<?php

namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterLogin {

  public function login() {

    if ($this->isLoggedIn()) {
      header('Location: http://' . $_SERVER['HTTP_HOST']);
    }
    // ユーザーが認証されると、ツイッター側で承認済みのrequset tokenとverifierの情報が渡されるので、この状態による分岐
    if (!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])){
      $this->_redirectFlow();
    } else {
      $this->_callbackFlow();
    }

  }
  // ログインしているかどうか確認
  public function isLoggedIn() {
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }

  private function _callbackFlow() {
    // requset tokenがツイッター側から返えされたものと格納したものが一致していない場合は不正であるので例外を飛ばす
    if ($_GET['oauth_token'] !== $_SESSION['oauth_token']) {
      throw new \Exception('invalid oauth_token');
    }

    $conn = new TwitterOAuth(
      API_KEY,
      API_SECRET,
      $_SESSION['oauth_token'],
      $_SESSION['oauth_token_secret']
    );
    // Access Tokenを取得 verifierを渡す
    $tokens = $conn->oauth('oauth/access_token',[
      'oauth_verifier' => $_GET['oauth_verifier']
    ]);

    $user = new User();
    $user->saveTokens($tokens);

    // セッションハイジャック(セッションを管理する際にクッキーにセッションIDが保存されるため、特定されるのを防ぐ)
    session_regenerate_id(true);
    $_SESSION['me'] = $user->getUser($tokens['user_id']);

    // request tokenは使わないのでunset
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);

    header('Location: http://' . $_SERVER['HTTP_HOST']);
  }

  // Request Tokenはユーザーを認証するまでの一時的なトークン
  // Access Tokenはそれ以降その後ユーザーに変わって色々な処理をするためのトークン

  // ツイッター接続から連携承認画面までリダイレクト
  private function _redirectFlow() {
    // TwitterOAuthのインスタンス生成
    $conn = new TwitterOAuth(API_KEY, API_SECRET);
    // request tokenをtwitterから発行 TwitterOAuthの機能(oauth)を使う
    // callbackはlogin.phpに設定
    $tokens = $conn->oauth('oauth/request_token', [
      'oauth_callback' => CALLBACK_URL
    ]);
    // $tokensの中にrequest tokenとsecretが入ったので$_SESSIONの中に格納
    $_SESSION['oauth_token'] = $tokens['oauth_token'];
    $_SESSION['oauth_token_secret'] = $tokens['oauth_token_secret'];
    // 連携認証画面へリダイレクト url()はTwitterOAuth機能参照
    $authorizeUrl = $conn->url('oauth/authorize', [
      'oauth_token' => $tokens['oauth_token']
    ]);
    header('Location: ' . $authorizeUrl);
    exit;
  }
}
