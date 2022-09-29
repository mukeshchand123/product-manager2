<?php 
 session_start();
 if(!isset($_SESSION['login']) || $_SESSION['login']!==true){
    header("location:login.php");
    exit;
  }
  require_once("../class/Operation.php");
    if($_SERVER ['REQUEST_METHOD'] == 'GET' ){
        $err ="";
        $id = $_SESSION['id'];
        $type = "text";
        $val = filter_var($_GET['i'], FILTER_SANITIZE_STRING);
        $_SESSION['val']=$val;
        $obj = new Operation();
        $result = $obj->getData('users','*',['id'=>$id]);
        $row =   $result->fetch(PDO::FETCH_ASSOC);
        switch($val){
            case "firstname":
               $data =  $row['firstname'] ;
               $_SESSION['data']=$data;
                break;
            case "lastname":
                $data =  $row['lastname'] ;
                $_SESSION['data']=$data;
                break;
            case "email":
                $data =  $row['email'] ;
                $_SESSION['data']=$data;
                $type = "email";
                break;
            case "phn": 
                $data =  $row['phn'] ;
                $_SESSION['data']=$data;
                break; 
            default:
              exit;              
        }
        
    }elseif($_SERVER ['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])){
        $err ="";
        $val = $_SESSION['val'];
        $id = $_SESSION['id'];
        $result=NULL;
       // $data = filter_var($_POST['new'], FILTER_SANITIZE_STRING);
        $obj = new Operation();
        switch($val){
            case "firstname":
               $data = filter_var($_POST['new'], FILTER_SANITIZE_STRING);
               $result = $obj->updateData('users',[$val=>$data],'id',$id);
                break;
            case "lastname":
                $data = filter_var($_POST['new'], FILTER_SANITIZE_STRING);
                $result = $obj->updateData('users',[$val=>$data],'id',$id);
                break;
            case "email":
                $data =  filter_var($_POST['new'], FILTER_SANITIZE_EMAIL);
                if(filter_var($_POST['new'], FILTER_VALIDATE_EMAIL)){
                    $res = $obj->getData('users','*',[$val=>$data]);
                    $num= $res->rowCount();
                    if($num>0){
                        $err = 'Email already exists.Enter a new Email.';
                    }else{
                    $result = $obj->updateData('users',[$val=>$data],'id',$id); 
                    }
                }else{
                    $err = 'Invalid email';
                }
                break;
            case "phn": 
                $data =  filter_var($_POST['new'], FILTER_SANITIZE_NUMBER_INT);
                $result = $obj->updateData('users',[$val=>$data],'id',$id);
                break; 
            default:
              exit;              
        }
      
        if($result){
            header("location:userdetails.php");
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
 
   
<div>
    <form action="user_update.php" method="post" enctype="multipart/form-data" >
   
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h1>Update</h1>
                    <p>Please Edit  Information:</p>
                    
                    <hr class="mb-3">
                    

                    <label for="old">Old <?php echo$val ?></label>
                    <input class="form-control" type="text" name="old"  value="<?php echo $_SESSION['data']; ?>" required><br>
              
                    <label for="new">New <?php echo$val ?></label>
                    <input class="form-control" type="text" name="new"  placeholder="new <?php echo"$val"; ?>"   required
                    <span class="error"><?php echo"$err"; ?></span> <br>   
                    <hr class="mb-3">
               
                    <input class="btn btn-primary" onclick="return confirm('Changes will be applied.Are you sure you want to continue?');" type="submit" name="create" value="Update">
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
