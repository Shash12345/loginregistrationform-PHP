<?php
require_once "config.php";

$username=$password=$confirm_password="";
$username_err =$password_err=$confirm_password_err="";
if($_SERVER['REQUEST_METHOD']=="POST")
{
       //CHECK IF USERNAME IS EMPTY
       if(empty(trim($_POST["username"]))){
              $username_err="username cannot be blank";
       }
       else{
              $sql="SELECT id FROM users where username=?";
              $stmt= mysqli_prepare($conn,$sql);
              if($stmt)
              {
                     mysqli_stmt_bind_param($stmt,"s",$param_username);
                     //set the value of param username
                     $param_username=trim($_POST['username']);
                     //try to execute this statement 
                     if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt)==1)
                            {
                                   $username_err="this username is already taken";
                            }
                            else{
                                   $username =trim($_POST['username']);
                            }
                     }
                     else{
                            echo "something went wrong";
                     }
              }
       }
       mysqli_stmt_close($stmt);

//check for password
if(empty(trim($_POST['password']))){
       $password_err="password cannot be blank";
}
elseif(strlen(trim($_POST['password']))<5){
       $password_err="password cannot be less than 5 chataceters ";
}
else{
       $password=trim($_POST['password']);
}
//check for confirm password field
if(trim($_POST['passwoed'])!=trim($_POST['confirm_password'])){
       $password_err="passwords should match";
}
//if there were no errors,go ahead and insert into the database
if(empty($username_err)&& empty($password_err)&& empty($confirm_password_err))
{
  $sql="INSERT INTO users(username,password) VALUES(?,?)";
  $stmt=mysqli_prepare($conn,$sql);
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
    //set these parameter
    $param_username=$username;
    $param_password=password_hash($password,PASSWORD_DEFAULT);
    //TRY TO EXECUTE THE QUERRY
    if(mysqli_stmt_execute($stmt))
    {
      header("location:login.php");
    }
    else{
      echo "something went wrong..cannot redirect!";
    }
  }
  mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PHP login system</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Php login system</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">contact us</a>
        </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
       <h3>Please Register Here:</h3>
       <hr>
       
<form class="row g-3" action="" method="post">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">username</label>
    <input type="text" class="form-control" name="username" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" class="form-control" name="password"id="inputPassword4">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">confirm Password</label>
    <input type="password" class="form-control" name="confirm_password"id="inputPassword4">
  </div>
   
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address </label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">City</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">State</label>
    <select id="inputState" class="form-select">
      <option selected>Choose...</option>
      <option>...</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>