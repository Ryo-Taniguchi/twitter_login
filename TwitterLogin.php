<?php


namespace MyApp;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterLogin {

  public function login() {

    // ユーザーが認証されると、ツイッター側でrequset tokenとverifierの情報が渡されるので、この状態による分岐
    if (!isset($_GET['oauth_token']) || !isset($_GET['oauth_verifier'])){
      $this->_redirectFlow();
    } else {
      $this->_callbackFlow();
    }

  }

  private function _callbackFlow() {
    // 一致していない場合は不正であるので例外を飛ばす
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

    $_SESSION['me'] = $user->getUser($tokens['user_id']);

    // request tokenは使わないのでunset
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);

    goHome();
  }

  // Request Tokenはユーザーを認証するまでの一時的なトークン
  // Access Tokenはそれ以降その後ユーザーに変わって色々な処理をするためのトークン

  private function _redirectFlow() {
    // ツイッターに接続する
    // TwitterOAuthのインスタンス生成
    $conn = new TwitterOAuth(API_KEY, API_SECRET);
    // request tokenをtwitterから取得するためTwitterOAuthの機能を使う
    $tokens = $conn->oauth('oauth/request_token', [
      'oauth_callback' => CALLBACK_URL
    ]);
    // $tokensの中にrequest tokenとsecretを格納できたので$_SESSIONの中に入れる
    $_SESSION['oauth_token'] = $tokens['oauth_token'];
    $_SESSION['oauth_token_secret'] = $tokens['oauth_token_secret'];
    // 連携認証画面へリダイレクト
    $authorizeUrl = $conn->url('oauth/authorize', [
      'oauth_token' => $tokens['oauth_token']
    ]);
    header('Location: ' . $authorizeUrl);
    exit;
  }
}
