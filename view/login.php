<?php
 session_start();
 if(isset($_SESSION['login'])){
       
    header("location:welcom.php");
    exit;
}else{
    session_destroy();
}
require_once("../class/Login.php");
if(isset($_POST['create'])){    
      
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $obj = new login();
        $row = $obj->login($email,$password);
        if($row){
           session_start();
           $_SESSION['email'] = $email;
           $_SESSION['username'] = $row['firstname'].' '.$row['lastname'];
           $_SESSION['id'] = $row['id'];
           $_SESSION['login'] = true;
           $_SESSION['phnNumber']= $row['phn'];
   
        //    $obj1 = new Operation();
        //    $st=$obj1-> updateData('users',['status'=>1],'id',$row['id']);
   
          
           
           header("location:welcome.php");
        }elseif($row === false){
           echo '<script type="text/javascript">
   
                 window.onload = function () { alert("wrong password"); }
   
                 </script>';
              
   
        }else{
           
           echo '<script type="text/javascript">
   
                  window.onload = function () { alert("user not registered.Please register before loging in."); }
        
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

    <title>Product_Manager|Login</title>
</head>
<body>
    <div>
        <?php require_once("nav1.php"); ?>
    </div>
    <div>
    <form action="login.php" method="post" enctype="multipart/form-data" >
   
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h1>Login</h1>
                    
                    <hr class="mb-3">
                    <label for="email">Email</label>    
                    <input class="form-control" type="email" name="email" id="email" placeholder="Something@gmail.com" required><br>

                     <label for="password">Password</label>
                     <input class="form-control" type="password" name="password" id="password" placeholder="******" required><br>
                     <hr class="mb-3">
                     <button class="btn btn-primary" type="submit" name="create" value="login">login</button>
                   
                   
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

