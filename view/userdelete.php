<?php 
session_start();
    if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
       header("location:login.php");
       exit;
     }
  require_once("../class/Operation.php");

 $image = array();
 
  $id = $_SESSION['id'];

    $obj = new Operation();
    $result = $obj->getData('product','*',['userid'=>$id]);
   // $row = $result->fetch(PDO::FETCH_ASSOC);
    while( $row = $result->fetch(PDO::FETCH_ASSOC)){
        $image[] = $row['image'];
    }
    
 
    
    $result1 = $obj->deleteData('product',['userid'=>$id]);
    $result2 = $obj->deleteData('category',['userid'=>$id]);
    $result3 = $obj->deleteData('users',['id'=>$id]);
    if($result3){
        if(!empty($image)){
        foreach($image as $x){
            //echo $x;
            unlink('../product/'.$x);
           
        }}
        header('location:logout.php');
    }
?>


       
