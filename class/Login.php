<?php 
require_once('Operation.php');

class login {

    function login($email,$password){

     $obj = new Operation();
  
     $result = $obj->getData('users','*',['email'=>$email]);
      
     
   
     $num_rows = $result->rowCount();
   
     if($num_rows > 0){
      $row = $result->fetch(PDO::FETCH_ASSOC); 
     
    
      if(md5($password)==$row['password']){
        //if password matches.
            return $row;
           
         } else {
          //wrong password
        return false;
         }
     }else{
      //email not found.
     return NULL;
       }

     }}