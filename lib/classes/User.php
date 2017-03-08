<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class User {
  public static function register($name, $pwd) {
    if(!isset($name) || !isset($pwd) || strlen($name) == 0 || strlen($pwd) == 0) {
      return false;
    }

    $hash = password_hash($pwd, PASSWORD_BCRYPT);

    $db = new Db();
    $db->query("INSERT INTO user (name, pwd) VALUES (?, ?)", array($name, $hash));

    if(!$db->error()) {
      // TODO: Why this => var_dump($db->results());
      return true;
    }

    return false;
  }

  public static function login($name, $pwd) {
    if(!isset($name) || !isset($pwd) || strlen($name) == 0 || strlen($pwd) == 0) {
      return false;
    }

    $db = new Db();
    $db->query("SELECT * FROM user WHERE name = ?", array($name));

    if(!$db->error() && $db->count() == 1) {
      $user = $db->results()[0];

      if($user->name==$name && password_verify($pwd, $user->pwd)) {
        // TODO: Maybe save jti on whitelist
        // TODO: ADD xsrf Token
        $jti = uniqid('', true);  // more entropy
        // $xsrf = '123'; //uniqid();

        $signer = new Sha256();
        $keychain = new Keychain();
        $token = (new Builder())
                ->setIssuer('http://example.com') // Configures the issuer (iss claim)
                ->setId($jti, true) // Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                ->set('uid', $user->id) // Configures a new claim, called "uid"
                ->set('name', $user->name) // Configures a new claim, called "name"
        //        ->set('xsrf-token', $xsrf) // Configures a new claim, called "xsrf-token"
                ->sign($signer, $keychain->getPrivateKey(Config::get('jwt/private'))) // creates a signature using "testing" as key
                ->getToken(); // return token as string

        return array(
          'jwt' => (string)$token
//          'xsrf-token' => $xsrf
        );
      }
    }

    return false;
  }

  public static function logout() {
    // TODO: Remove from whitelist
  }

  public static function isLoggedIn($token) {
    // TODO: Validate XSRF-Token
    try {
      $token = (new Parser())->parse((string) $token); // Parses from a string
      $signer = new Sha256();
      $keychain = new Keychain();
      return $token->verify($signer, $keychain->getPublicKey(Config::get('jwt/public')));
    } catch (Exception $e) {
      // In case the JSON parsers dies (payload is unuseable)
      return false;
    }
  }
}
