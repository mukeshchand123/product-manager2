<?php
  session_start();
  if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
      header("location:login.php");
      exit;
  }
  require_once('../class/Operation.php');
  require_once('../class/Database.php');
  
  
  $name = array();
  $count=1;
  $count = NULL;
  $cat = array();
  $msg = "Category:All";
  $flag = 1;
  $id = $_SESSION['id'];
  $obj = new operation();
  $stmt = new Database();
//fetching data
$sql = "SELECT `product`.`id`,`product`.`userid`, `product`.`image`,`product`.`name` as `pname` , `product`.`price` ,`prod-cat`.`prod`,`prod-cat`.`cat` ,`category`.`name` from `product` 
        left join  `prod-cat` on `prod-cat`.prod=`product`.`id` 
        LEFT JOIN `category` on `category`.`id`= `prod-cat`.`cat` where `product`.`userid` ='$id';";

$pdo = $stmt->con();
$result = $pdo->query($sql);

if($_SERVER ['REQUEST_METHOD'] == 'POST'){
    
   
  
    if(isset($_POST['submit'])){
      foreach( $_POST['dropdown'] as $selected){
      $name[] =$selected;
      $msg = $msg.$selected;
    } 
    $flag = 0;
   // $msg = "Category:".;
  }
   
   // for searchbox
    if(isset($_POST['create'])){
        $id = $_SESSION['id'];
        if(!empty($_POST['search'])){
        $search = trim($_POST['search']);
        $search = htmlspecialchars($search);
       
       $sql = "SELECT `product`.`id`,`product`.`userid`, `product`.`image`,`product`.`name` as `pname` , `product`.`price` ,`prod-cat`.`prod`,`prod-cat`.`cat` ,`category`.`name` from `product` 
        left join  `prod-cat` on `prod-cat`.prod=`product`.`id` 
        LEFT JOIN `category` on `category`.`id`= `prod-cat`.`cat` where `product`.`userid` ='$id' and 
         `product`.`name` like '%$search%' or `product`.`price`  like '%$search%' or `category`.`name` like '%$search%' ;";
      
     
      $result = $pdo->query($sql);
       
    }
}
   

}


?>

<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


<title>PHP|CRUD</title>
</head>
<body>


<div>
<?php require_once("../view/nav3.php"); ?>
</div>
<!-- forms -->
<div class="container">
    <!-- product according to category -->   
    <form action="fetch.php" method="post" style=" float:left" >
                <label for="productCategory">Product Category</label>
                  <select name = "dropdown[]" multiple required>
                  
                       <?php $res = $obj->getData('category','*',['userid'=>$id]);
                            while ($row1 = $res->fetch(PDO::FETCH_ASSOC)){ ?>
                            <?php
                            if(in_array($row1['name'],$name)){?>
                        
                                <option value = "<?php echo $row1['name']?>" selected ><?php echo $row1['name']?></option>
                          <?php  }else{
                            ?>
                                    <option value = "<?php echo $row1['name']?>" ><?php echo $row1['name']?></option>
                                 <?php } } ?>
                                 <input for ="dropdown"  class=" btn-primary" type="submit" name="submit" value="Select" style="margin: 2px;position:relative;">

                  </select>
                              
    </form>
    
    <!-- search form -->
    <form action="fetch.php" method="post" style=" float:right">
          <input type="text" name="search" style="margin: 2px;position:relative;left:0%;" placeholder="Search" required>
          <input class=" btn-primary" type="submit" name="create" value="Search" style="margin:2px;position:relative;">
    </form> 
</div><br><br><br><br><br>

    <div class ="container" >

    <table align="center" border="1px" width="800px" style="  text-align: center;">
<tr>
 
   <tr> <th colspan="8" ><h2>Product table</h2></th></tr>
    <th ><h2>S.n</h2></th>
    <th ><h2>userid</h2></th>
    <th><h2>Product-Name</h2></th>
    <th><h2>Product-category</h2></th>
    <th><h2>Product-price</h2></th>
    <th><h2>Product-Image</h2></th>
    <th><h2>Action</h2></th>

    
</tr>
<?php

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
       
        echo $count;
        if(($flag == 1 ||in_array($row['name'],$name))  && $_SESSION['id'] == $row['userid'] ){
          echo"
          <tr>
              <td>".$row['id']."</td>
              <td>".$id."</td>
              <td>".$row['pname']."</td>
              <td>".$row['name']."</td>
              <td>".$row['price']."</td>
              <td>".$row['image']."</td>
              
              <td><a href='delete.php ? i=$row[id]'onclick=\"return confirm('Are you sure you want to delete?');\">Delete <a href='update.php ? i=$row[id]'>Update </td>
          </tr> ";         
              
  
       }
      }
      
       

               
       
     ?>
</tablw>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
