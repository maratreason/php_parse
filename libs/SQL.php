<?php

class SQL {
  private static $instance;
  private $db;

  const MYSQL_SERVER = 'localhost';
  const MYSQL_DB = 'parser';
  const MYSQL_USER = 'root';
  const MYSQL_PASSWORD = '';

  public static function getInstance() {
    if (self::$instance == null) {
      self::$instance = new SQL();
    }

    return self::$instance;
  }

  private function __construct() {
    setlocale(LC_ALL, 'ru_RU.UTF8');
    $this->db = new PDO('mysql:host=' . SQL::MYSQL_SERVER . ';dbname=' . SQL::MYSQL_DB, SQL::MYSQL_USER, SQL::MYSQL_PASSWORD);
    $this->db->exec('SET NAMES UTF8');
    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }


  public function insert($table, $object) {
    $columns = array();
    $masks = array();

    foreach ($object as $key => $value) {
      $columns[] = $key;
      $masks[] = ":$key";

      if ($value === null) {
        $object[$key] = 'NULL';
      }
    }

    $columns_s = implode(',', $columns);
    $masks_s = implode(',', $masks);

    $query = "INSERT INTO $table ($columns_s) VALUES ($masks_s)";

    $q = $this->db->prepare($query);
    $q->execute($object);

    if ($q->errorCode() != PDO::ERR_NONE) {
      $info = $q->errorInfo();
      die($info[2]);
    }

    return $this->db->lastInsertId();
  }

  public function clearTable($table) {
    $sth = $this->db->prepare("TRUNCATE TABLE `$table`");
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchAll($table) {
    $sth = $this->db->prepare("SELECT * FROM `$table`");
    $sth->execute();
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $array;
  }
}
