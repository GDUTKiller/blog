<?php
class YDB {
  private $link;
  
  public function __construct() {
    $this->conn();

  }

  /**
   * link DB
   * @return true | die()
   */ 
  private function conn() {
    $cfg = require(ROOT . '/lib/config.php');
    $this->link = new mysqli($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['db']);
    if($this->link->connect_error) {
      die('database link fail' . $this->link->connect_error);
    }
    $this->link->query('set names ' . $cfg['charset']);
    $this->link->query('use blog');
    return true;
  }


  /**
   * record log
   * @param str $str The string will be record
   */
  private function log($str) {
    $filename = ROOT . '/log/' . date('Ymd') . '.txt';
    $log = "-----------------------------------------\n" . date('Y/m/d H:i:s') . "\n" . $str . "\n" . "-----------------------------------------\n\n";
    file_put_contents($filename, $log, FILE_APPEND);

  }



  /**
   * function query
   * @param str $sql 
   * @return resoure
   */
  public function query($sql) {
    $rs = $this->link->query($sql);
    if($rs) {
      $this->log($sql);
    } else {
      $this->log($sql . '\n' . $rs->error);
    }

    return $rs;
  }


  /**
   * function get mutiple lines data
   * @param str $sql
   * @return mixed bool false | array $data
   */
  public function getAll($sql) {
    $rs = $this->query($sql);
    if(!$rs) {
      return false;
    }
 
    $data = array();
    while($row = $rs->fetch_assoc()) {
      $data[] = $row;

    }
    return $data;
  }

  /**
   * function select one row of the sql result
   * @param str $sql 
   * return mixed false | arr
   */
  public function getRow($sql) {
    $rs = $this->query($sql);
    if(!$rs) {
      return false;
    }
    return $rs->fetch_assoc();

  }
  

  /**
   * function select only one result
   * @param str $sql
   * @return mixed false | data
   */
  public function getOne($sql) {
    $rs = $this->query($sql);
    if(!$rs) {
      return false;
    } else {
      return $rs->fetch_row()[0];
    }
  }


  /**
   * function execute insert sql or update sql
   * @param str table name 
   * @param arr data 
   * @param str insert or update
   * @param str where 
   * 
   * @return resoure 
   */
  public function exec($table, $data, $act='insert', $where=0) {
    if($act == 'insert') {
      $sql = "insert into $table (";
      $sql .= implode(',', array_keys($data) ) . ") values ('";
      $sql .= implode("','", array_values($data)) . "')";
      return $this->query($sql);
    } else if($act == 'update') {
      $sql = "update $table set ";
      foreach($data as $k=>$v) {
        $sql .= $k . "='" . $v . "',";
      }
      $sql = rtrim($sql , ',') . " where ".$where;
      return $this->query($sql);


    }

  }

  /**
   * function get last insert id
   * @return int id
   */
  public function getLastId() {
    return $this->link->insert_id;
  }

}
