<?php

class Db {
  private $_pdo;
  private $_query;
  private $_error;
  private $_results;
  private $_count;

  public function __construct() {
    try {
      $this->_pdo = new PDO('mysql:host='.Config::get('db/host').';dbname='.Config::get('db/dbname'), Config::get('db/user'), Config::get('db/pwd'));
    } catch (PDOException $e) {
      // die($e->getMessage());
      die('Error! Code: 001, Please inform administrator');
    }

    $this->_count = 0;
    $this->_error = false;
  }

  public function query($sql, $params = array(), $resultType = PDO::FETCH_OBJ) {
    $this->_error = false;

    if($this->_query = $this->_pdo->prepare($sql)) {
      if(count($params)) {
        $x = 1;
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }

      if($this->_query->execute()) {
        $this->_results = $this->_query->fetchAll($resultType);
        $this->_count = $this->_query->rowCount();
      } else {
        $this->_error = true;
      }
    } else {
      $this->_error = true;
    }

    return $this;
  }

  public function results() {
    return $this->_results;
  }

  public function error() {
    return $this->_error;
  }

  public function count() {
    return $this->_count;
  }
}
