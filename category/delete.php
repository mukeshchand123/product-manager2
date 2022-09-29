<?php
session_start();
require_once('../class/Operation.php');

if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
header("location:login.php");
}


$id = filter_var($_GET['i'],FILTER_SANITIZE_NUMBER_INT);
 
//$_SESSION['flag'] = 0;
// if(!$res){
//    header('location:fetch.php');
//    exit; 
// }
$obj = new operation();
$result =  $obj->getData('prod-cat','*',['cat'=>$id]);
$num = $result->rowCount();
//$rows = $result->fetch(PDO::FETCH_ASSOC);

if($num>0){

    echo '<script type="text/javascript">
   
                 window.onload = function () { alert("Cannot delete category associated with product."); }
   
                 </script>';
                 
  // $_SESSION['flag']=1;
    header("refresh:0.01;url=fetch.php");
    exit;
}



$res = $obj->getData('category','*',['id'=>$id]);
$row = $res->fetch(PDO::FETCH_ASSOC);
if($row['userid']==$_SESSION['id']){
$result = $obj->deleteData('category',['id'=>$id]);
if($result!=0){
    header("location:fetch.php");
}
}

//  "DELETE FROM users WHERE `users`.`id` = 22"?
?>