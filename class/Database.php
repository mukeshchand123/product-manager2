<?php 
class Database{
  private $host = 'localhost';
  private $user = 'root';
  private  $password= '';
  private $db_name = 'product-manager2';
  protected $pdo = NULL;
  protected $error = NULL;
  public function __construct(){
    $dsn = "mysql:host=".$this->host.";dbname=".$this->db_name;
    
    // create a PDO instance
    try {
        //code...
        $this->pdo = new PDO($dsn,$this->user,$this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        //throw $th;
        $this->error = $e->getMessage();
        exit;
    }
  }
   
   public function con(){
    return $this->pdo;
   }
  }

?>