<?php
 session_start();

 //check if user is logged in
 if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
   header("location:login.php");
 }
 // require_once('class/Query1.php');
 // require_once('class/file.php');
 require_once('../class/Operation.php');
 require_once('../class/file.php');
 // require_once('validate.php');
  $_SESSION['count'] =0;
 
 if($_SESSION['count']==0){
     $name= $price="";
 }
 //     // if updated value is invalid
 if($_SERVER ['REQUEST_METHOD'] == 'GET'){
    
     $id = filter_var($_GET['i'],FILTER_SANITIZE_NUMBER_INT);
     
     $obj = new Operation();
     $result = $obj->getData('product','*',['id'=>$id]);
     $row = $result->fetch(PDO::FETCH_ASSOC);
     $result1 = $obj->getData('category',"*",['userid'=>$_SESSION['id']]);
     $name  = $row['name'];
     $price   = $row['price'];
     $image = $row['image'];
     $_SESSION['newid']=$id;
     $_SESSION['image']=$image;
  }elseif ( isset($_POST['create'])) {
     $_SESSION['count'] =1;
     $id = $_SESSION['newid'];
     $image= $_SESSION['image'];
     # code...
     $obj = new operation();
    $productName  = filter_var($_POST['productName'],FILTER_SANITIZE_STRING);
    $productPrice = filter_var($_POST['productPrice'],FILTER_SANITIZE_STRING);
   
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

 
           //update in case data is valid
           if(!empty($productName)&&!empty($productPrice)&&$valid){
                          $dir=$fileobj->file_upload($filename,$tempname,$dirname,$productName);
                          $data =['name'=>$productName,'price'=>  $productPrice,'image'=>$dir];
                          // $dirname = 'regs';
                          
                          $result= $obj->updateData('product',$data,'id',$id); 
                          if($result== true){
                            //update prod-cat table
                            $res = $obj->getData('prod-cat','*',['prod'=>$id]);
                          // fetch old relations;
                            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                                $n_id[] = $row['id'];
                                $n_catid[]=$row['cat'];
                            }
                            
                            //add new categories to product
                            foreach($cat_id as $cat){
                                if(!in_array($cat, $n_catid)){
                                    $res = $obj->insertData('prod-cat',['prod'=>$id,'cat'=>$cat]);
                                }
                            }                            
                             unlink($image);
                             header("location:fetch.php");
                           }   
                           elseif($result==false){
                               //if update failed
                               unlink($dir);
                               $_SESSION['newid']=$id;
                               header("location:update.php");
                           }   
                       }else{
                         echo '<script type="text/javascript">
 
                            window.onload = function () { alert("Please enter valid information."); }
 
                           </script>';
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
    <?php require_once("../view/nav3.php"); ?>
    </div>
<form action="update.php" method="post" enctype="multipart/form-data" >
   
   <div class="container">
       <div class="row">
           <div class="col-sm-3">
              
               
               <hr class="mb-3">
              
               <label for="productName">Product Name</label>
               <input class="form-control" type="productName" name="productName" placeholder="Product Name" value="<?php echo $name; ?>" required><br><br>
              
               <label for="productCategory">Product Category</label>
                  <select name = "dropdown[]" multiple >
                    <?php while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {?>
                        <option value = "<?php echo $row1['id']?>" ><?php echo $row1['name']?></option>
                    <?php } ?>

                  </select><br><br>

               <label for="productPrice">Product Price</label>
               <input class="form-control" type="productPrice" name="productPrice"  placeholder="Product Price"  value="<?php echo $price; ?>"  required><br><br>

               <label for="file">Product Image</label>
               <input type="file" name="file" id="file" accept="image/jpeg" required><br><br>
                        
               <hr class="mb-3">
               
               <input class="btn btn-primary"  onclick="return confirm('Are you sure you want to continue?');" type="submit" name="create" value="Update-Product">
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