<?php
require_once('Database.php');

class Operation extends Database{

    public function insertData($table,$condition=""){

        if($condition!=""){
          
           foreach($condition as $key=>$val){
               $fieldarr[] = $key;
               $valuesarr[] = $val; 
           }
           $field = implode("`,`", $fieldarr);
           $placeholder = implode(",:", $fieldarr);
           $field = '`'.$field.'`';
           $value = implode("','", $valuesarr);
           $value = "'".$value."'";
           $sql = "INSERT INTO `$table` ($field) VALUES (:$placeholder)";
           $stmt = $this->pdo->prepare($sql);
            // echo$sql."<br>";
            // echo"<pre>";
            // print_r($condition);
           $stmt->execute($condition);
       //return $stmt;
        
          
          
           if($stmt){
            // echo"Data inserted successfully.<br>"; display a message box.
            return true;
           }else {
            return false;
           }
        
    
        }  
    }

    public function getData($table,$field='*',$condition=""){

      

        $sql = "SELECT $field FROM `$table`";
        $data = array();
        if($condition!=""){
            $sql = $sql." WHERE  ";
            $c = count($condition);
            $i=1;
           foreach($condition as $key=>$val){
            array_push($data,$val);
                if($i==$c){
                    $sql = $sql." `$key`=:$key ";
                }else{
                    $sql = $sql."  `$key`=:$key AND ";
                }
                $i++;
           }
        }
       
        
       if($condition!=""){
        $stmt = $this->pdo->prepare($sql);
       $stmt->execute($condition);
        }else{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
      // $stmt= $this->pdo->query($sql);
       return $stmt;
        }

        public function deleteData($table,$condition=""){
            if($this->error){
                return "Connection Error";
               }

            $sql = "DELETE FROM `$table`";
        
            if($condition!=""){
                $sql = $sql." WHERE ";
                $c = count($condition);
                $i=1;
               foreach($condition as $key=>$val){
                    if($i==$c){
                        $sql = $sql." `$key`=:$key ";
                    }else{
                        $sql = $sql."  `$key`=:$key AND ";
                    }
                    $i++;
               }
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute($condition);
               return $stmt;
            
            }else{
                return 0;
            }
          
            
        
        }

        public function updateData($table,$condition="",$field,$value){

          
            $sql = "UPDATE `$table`";
        
            if($condition!=""){
                $sql = $sql." SET ";
                $c = count($condition);
                $i=1;
               foreach($condition as $key=>$val){
                    if($i==$c){
                        $sql = $sql." `$key`=:$key ";
                    }else{
                        $sql = $sql."  `$key`=:$key, ";
                    }
                    $i++;
               }
               $sql = $sql." WHERE `$field` = '$value'";
             
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute($condition);
               return $stmt;
            
            
            }else{
                return 0;
            }
        }
          
            //funnction for search
public function searchData($table,$search,$key){
    if($this->error){
        return "Connection Error";
       }
    $sql = "SELECT * FROM `$table` WHERE";
    $c = count($key);
                $pattern = '%' . $search . '%';
                $i=0;
                foreach($key as $val){
                    if($i<$c-1){
                        $sql = $sql." `$key[$i]` LIKE :pattern OR ";
                    }else{
                        $sql = $sql." `$key[$i]` LIKE :pattern ";
                    }
                    $i++;
                }
               // echo $sql;
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':pattern' => $pattern]);
                return $stmt;
                 
                //echo" $sql";
               
        
        
            }
 

}


?>