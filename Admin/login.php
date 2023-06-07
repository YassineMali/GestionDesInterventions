<?php
 SESSION_START();
 $eror_login="";
 $eror_password="";
 $login="";
 $bool=0;
 if(isset($_POST["login"]))
 {
   $login=$_POST["login"];
   $password=$_POST["pass"];
   if(empty($login))
   {
     $eror_login="login est obligatoire";
     $bool=1;
   }
   if(empty($password))
   {
     $eror_password="mot de passe est obligatoire";
     $bool=1;
   }
   if($bool==0)
   {
       require "bd.php";
       $query = "SELECT * FROM user WHERE username = :login AND password = :password";
       $stat=$con->prepare($query);
       $password=md5($password);
       $stat->execute(
         array(':login' => $login ,':password' => $password)
       );
       $data=$stat->fetchAll();
       if(count($data)==1 and $data[0]['username']== 'admin')
       {

          $_SESSION['admin']=$data[0]['id'];
          header("Location:index.php");

       }
       else{
         $eror_password="login ou mot de passe est incorrect";
       }
  }
}

  
                      


// ----------------------------------------------------------------

 

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
   
<div class="d-flex justify-content-center mt-5">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class=" first">
      <img src="../image/logo.svg"  alt="User Icon"  style="width:100px"/>
    </div>

    <form method="post" action="#">
      <h3 class="text-danger"><?= $eror_login ?></h3>
      <input type="text"  class=" second" name="login" placeholder="Utilisateur" value="" >
      <h3 class="text-danger"><?= $eror_password?></h3>
      <input type="password"  class=" second" name="pass" placeholder="Mot de Passe" value="">
      <input type="submit" class=" second mt-3" value="Valider">

    </form>
  </div>
</div>
 
</body>
</html>