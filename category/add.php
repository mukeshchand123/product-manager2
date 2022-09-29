<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
    header("location:login.php");
    exit;
  }
  require_once("../class/Operation.php");
if(isset($_POST['create'])){  
    $categoryName  = filter_var($_POST['categoryName'],FILTER_SANITIZE_STRING);
    $categoryDescription = filter_var($_POST['categoryDescription'],FILTER_SANITIZE_STRING);
    $cat_user_id = $_SESSION['id'];
    $data = ["userid"=> $cat_user_id,"name"=>$categoryName,"description"=>  $categoryDescription];
    $obj = new Operation();
    $result = $obj->insertData('category',$data);
   
    if($result){
        echo "Category added sucessfully";
        header('location:fetch.php');
    }else{
        echo "Error Occured.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
<div>
       <?php require_once("../view/nav2.php"); ?>
    </div>

<form action='add.php' method="post" enctype="multipart/form-data" >
   
   <div class="container">
       <div class="row">
           <div class="col-sm-3">
              
               
               <hr class="mb-3">
              
               <label for="categoryName">Category Name</label>
               <input class="form-control" type="categoryName" name="categoryName" placeholder="Category Name" required><br>
              
               <label for="categoryDescription">Category Description</label>
               <textarea class="form-control" type="text" name="categoryDescription"  placeholder="Category Description"  required></textarea><br>
                        
               <hr class="mb-3">
               
               <input class="btn btn-primary"  onclick="return confirm('Are you sure you want to continue?');" type="submit" name="create" value="Add-Category">
           </div>
       </div>
   </div>

</form>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>