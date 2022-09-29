<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
    header("location:login.php");
    exit;
  }
require_once("../class/Operation.php");


$id = $_SESSION['id'];

$obj = new Operation();
$result = $obj->getData('users','*',['id'=>$id]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>User Details</title>
</head>
<body>
    <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="welcome.php">PHP|CRUD</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="product.php">Product</a>
      </li>
     
      <li class="nav-item">
        <a class="nav-link" href="category.php">Category</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../view/settings.php">Settings</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
      
    

      
    </ul>
  </div>
</nav>   
 </div>
 
    <div class="container">
      <h1>User Details</h1> 
      <hr>  
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)){ 
               echo "First Name: " .$row['firstname']."<a href='user_update.php?i=firstname'> Edit</a><br>";
               echo "Last Name: " .$row['lastname']."<a href='user_update.php?i=lastname'> Edit</a><br>";
               echo "Email: " .$row['email']."<a href='user_update.php?i=email'> Edit</a><br>";
               echo "Phone No: " .$row['phn']."<a href='user_update.php?i=phn'> Edit</a><br>";
           }
           ?>
              <hr>  
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>