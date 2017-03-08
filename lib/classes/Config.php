<?php

class Config {
  public static function get($value) {
    switch($value) {
      case 'db/host':
        return 'localhost';

      case 'db/dbname':
        return 'jwt-login';

      case 'db/user':
        return 'root';

      case 'db/pwd':
        return 'root';

      case 'jwt/private':
        return 'file://' . __DIR__ . '/../../jwt.key';

      case 'jwt/public':
        return 'file://' . __DIR__ . '/../../jwt.pub';

      default:
        return NULL;
    }
  }
}
