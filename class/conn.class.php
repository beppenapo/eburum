<?php
class Conn{
    private $dbhost;
    private $dbuser;
    private $dbpwd;
    private $dbname;
    private $dsn;
    public $conn;

    function __construct(){
        $this->dbhost = getenv('EBH');
        $this->dbuser = getenv('EBU');
        $this->dbpwd = getenv('EBP');
        $this->dbname = getenv('EBD');
        $this->dsn = "pgsql:host=".$this->dbhost." user=".$this->dbuser." password=".$this->dbpwd." dbname=".$this->dbname;
    }

  protected function connect(){
    $this->conn = new PDO($this->dsn);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  public function pdo(){
    if (!$this->conn){ $this->connect();}
    return $this->conn;
  }

  public function __destruct(){
    if ($this->conn){
      $this->conn = null;
    }
  }

}

?>
