<?php
session_start();
require_once('../class/Operation.php');
require_once('../class/File.php');

if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
header("location:login.php");
}


$id = filter_var($_GET['i'],FILTER_SANITIZE_NUMBER_INT);
echo $id;


$obj = new operation();
$res = $obj->getData('product','*',['id'=>$id]);
$row = $res->fetch(PDO::FETCH_ASSOC);
if($row['userid']==$_SESSION['id']){
$result = $obj->deleteData('product',['id'=>$id]);
//$res = $obj->deleteData('prod-cat',['prod'=>$id]);
if($result!=0 && $res!=0){
    unlink($row['image']);
    header("location:fetch.php");
}
}else{
    echo "Not authorized.";
}
?>