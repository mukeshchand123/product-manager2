<?php 
session_start();

//check if user is logged in
if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
  header("location:login.php");
}
// require_once('class/Query1.php');
// require_once('class/file.php');
require_once('../class/Operation.php');
// require_once('validate.php');
 $_SESSION['count'] =0;

if($_SESSION['count']==0){
    $name= $desc="";
}
//     // if updated value is invalid
if($_SERVER ['REQUEST_METHOD'] == 'GET'){
   
    $id = filter_var($_GET['i'],FILTER_SANITIZE_NUMBER_INT);
   
    $obj = new Operation();
    $result = $obj->getData('category','*',['id'=>$id]);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $name  = $row['name'];
    $desc   = $row['description'];
    $_SESSION['newid']=$id;
 }elseif ( isset($_POST['create'])) {
    $_SESSION['count'] =1;
    $id = $_SESSION['newid'];
   
    # code...
    
    $name    = filter_var($_POST['categoryName'], FILTER_SANITIZE_STRING);
    $desc  = filter_var($_POST['categoryDescription'], FILTER_SANITIZE_STRING);

          //update in case data is valid
          if(!empty($name)&&!empty($desc)){
                         
                          $data =['name'=>$name,'description'=>$desc];
                         // $dirname = 'regs';
                          $obj = new operation();
                         $result= $obj->updateData('category',$data,'id',$id); 
                         if($result== true){
                            header("location:fetch.php");
                          }   
                          elseif($result==false){
                              //if update failed
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
    <title>User Registration | PHP</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <div>
    <?php require_once("../view/nav2.php"); ?>
    </div>
   
<div>
    <form action="update.php" method="post" enctype="multipart/form-data" >
   
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h1>Update</h1>
                    <p>Please Edit  Information:</p>
                    
                    <hr class="mb-3">
                    

                    <label for="categoryName">Category Name</label>
                    <input class="form-control" type="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo"$name"; ?>" required><br>
              
                    <label for="categoryDescription">Category Description</label>
                    <input class="form-control" type="textarea" name="categoryDescription"  placeholder="Category Description" value="<?php echo"$desc"; ?>"  required><br>
                        
                    <hr class="mb-3">
               
                    <input class="btn btn-primary"  onclick="return confirm('Are you sure you want to continue?');" type="submit" name="create" value="Update">
                </div>
            </div>
        </div>

    </form>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
