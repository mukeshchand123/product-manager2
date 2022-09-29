<?php
session_start();
require_once('../class/Operation.php');
require_once('../class/File.php');
if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
    header("location:login.php");
    exit;
  }

if(isset($_POST['create'])){  
    $productName  = filter_var($_POST['productName'],FILTER_SANITIZE_STRING);
    $productPrice = filter_var($_POST['productPrice'],FILTER_SANITIZE_STRING);
    $obj1= new Operation();
    foreach($_POST['dropdown'] as $selected){
        $cat_id[] = $selected;
    }
  
    $dirname = 'img';
    $filename = $_FILES['file']['name'];
    $tempname =  $_FILES['file']['tmp_name'];
  
    $fileobj = new Filehandling();
    $validext =  ['image/jpeg'];
    $ext = $_FILES['file']['type'];
   
    $valid = $fileobj->fileValidation($ext,$validext);

    if($valid){
        $dir = $fileobj->file_upload($filename, $tempname, $dirname,$productName);
       
        $data = ['userid'=> $_SESSION['id'],'name'=> $productName,'price'=> $productPrice,'image'=>$dir];
        $res =$obj1->insertData('product',$data);
       
    
        if($res){
            $res1 = $obj1->getData('product','*',['userid'=>$_SESSION['id'],'name'=>$productName]);
            $row =   $res1->fetch(PDO::FETCH_ASSOC);
            $prod_id = $row['id'];
          //  $data1 = ['prodid'=>$prod_id,'catid'=>$id]
            echo $prod_id."<br>";
            foreach($cat_id as $id){
            $res1 = $obj1->insertData('prod-cat',['prod'=>$prod_id,'cat'=>$id]);  
        }
           header("location:fetch.php");
        }else{
            unlink($dir);
        }
    }else{
        var_dump($valid);
        echo"Only .jpg  files are allowed";
    }

   
}
    $id = $_SESSION['id'];
    $obj= new Operation();
    $result = $obj->getData('category',"*",['userid'=>$id]);


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
     <?php require_once("../view/nav3.php"); ?>
</div>
<form action="add.php" method="post" enctype="multipart/form-data" >
   
   <div class="container">
       <div class="row">
           <div class="col-sm-3">
              
               
               <hr class="mb-3">
              
               <label for="productName">Product Name</label>
               <input class="form-control" type="productName" name="productName" placeholder="Product Name" required><br><br>
              
               <label for="productCategory">Product Category</label>
                  <select name = "dropdown[]"  multiple required>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) {?>
                        <option value = "<?php echo $row['id']?>  " ><?php echo $row['name']?></option>
                   <?php } ?>                      

                  </select><br><br>

              
              

               <label for="productPrice">Product Price</label>
               <input class="form-control" type="productPrice" name="productPrice"  placeholder="Product Price"  required><br><br>

               <label for="file">Product Image</label>
               <input type="file" name="file" id="file" accept="image/jpeg" required><br><br>
                        
               <hr class="mb-3">
               
               <input class="btn btn-primary"  onclick="return confirm('Are you sure you want to continue?');" type="submit" name="create" value="ADD-Product">
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