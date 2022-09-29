<?php
 session_start();
 if(isset($_SESSION['login'])){
       
    header("location:welcom.php");
    exit;
}else{
    session_destroy();
}
require_once("../class/Registration.php");
$firstname=$lastname=$email=$phnNumber="";
$email_err=$password_err="";
if(isset($_POST['create'])){
        
        $firstname =  filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
        $lastname  = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
        $phnNumber     = filter_var($_POST['phnNumber'], FILTER_SANITIZE_NUMBER_INT);
        $email     =   filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
       
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Invalid Email.";
        }

        $password     = md5($_POST['password']);
        $conf_password = md5($_POST['confirm-password']) ;   

        if($password != $conf_password){
            $password_err="Passwords doesn't match.";
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) && $password_err == ""){
            $data =['firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'phn'=>$phnNumber,'password'=>$password];
            $obj = new Registration();
            $result= $obj->register($data,$email);

            if($result==false){
               
                echo '<script type="text/javascript">

                       window.onload = function () { alert("email alraedy exist."); }

                      </script>';
            }elseif($result == true){
                echo '<script type="text/javascript">

                       window.onload = function () { alert("User Registered Sucessfully."); }

                      </script>';
            }
            
           
            }else{
                echo '<script type="text/javascript">

                  window.onload = function () { alert("Please enter valid info."); }
 
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

    
    <title>User Registration</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
</head>
<body>


<div>
<div>
        <?php require_once("nav1.php"); ?>
    </div>
    
</div>

<div>
    <form action="register.php" method="post" enctype="multipart/form-data" >
   
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h1>Registration</h1>
                    <p>Please Enter Valid Information:</p>
                    
                    <hr class="mb-3">
                   
                    <label for="firstName">First Name</label>
                    <input class="form-control" type="firstName" name="firstName" placeholder="First Name" value="<?php echo $firstname;?>" required><br>
                   
                    <label for="lastName">Last Name</label>
                    <input class="form-control" type="lastName" name="lastName"  placeholder="Last Name"  value="<?php echo $lastname;?>" required><br>

                    <label for="phnNumber">Phone Number</label>
                    <input class="form-control" type="phnNumber" name="phnNumber"  placeholder="Phone Number"  value="<?php echo $phnNumber;?>" required><br>
                   
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email"  placeholder="something@other.com"  value="<?php echo $email;?>" required>
                    <span class="error"> <?php echo $email_err;?></span><br>
                    

                    

                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password"  placeholder="Password" required><br>

                    
                    <label for="confirm-password">Confirm Password</label>
                    <input class="form-control" type="password" name="confirm-password"  placeholder="Password" required>
                    <span class="error"> <?php echo $password_err;?></span><br>
                   
                     

                    <hr class="mb-3">
                    
                    <input class="btn btn-primary" type="submit" name="create" value="Sign Up">
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