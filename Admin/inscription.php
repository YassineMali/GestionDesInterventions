<?php
SESSION_START();
if(!isset($_SESSION['admin']))
{
header("Location:login.php");
}
$username="";$ereusername="";
$password="";$erepassword="";
$Confirmer="";$ereConfirmer="";
$num_tel="";$erenum_tel="";
$message="";$erename="";
require "bd.php";

if(isset($_POST["username"]))
{
    $username=$_POST["username"];
    $password=$_POST["password"];
    $Confirmer=$_POST["Confirmer"];
    $num_tel=$_POST["num_tel"];
    if(empty($username)){$ereusername=" username est obligatoire";}
    if(empty($password)){$erepassword=" mot de passe est obligatoire";}
    if(empty($Confirmer)){$ereConfirmer=" Confirmation de mot de passe est obligatoire";}
    if(empty($num_tel)){$erenum_tel=" le numero de téléphone est obligatoire";}
    if(empty($ereusername)&&empty($erepassword)&&empty($ereConfirmer)&&empty($erenum_tel)){
        if($password==$Confirmer)
        {   $query="SELECT * FROM fac.user where username=:username";
            $stat=$con->prepare($query);
            $stat->execute(array(':username' => $username));
            $data=$stat->fetchAll();
            if(!$data){
                $query="insert Into user values(NULL,:username,:password,:num_tel)";
                $stmt=$con->prepare($query);
                $password=md5($password);
                $stmt->execute(array(":username"=>$username,":password"=>$password,":num_tel"=>$num_tel));
                $message="votre inscription est enregistrer";
        }
        else{
            $erename="Ce nom deja exist saisir un autre nom";
        }
    }
        else{
            $ereConfirmer="Ereur de confirmation de mot de passe";
        }
         
    }
}
require "menu.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
<div class="  d-flex justify-content-center  marg marg2 text-center">
        <form method="post" class="py-2" id="formContent" action="#">
        <div class="py-2 flex mt-3">
          <div class="marg1">
            <label class="text-left  ml-5   text-info size">Nom</label>  
            <input type="text" class="fadeIn second" name="username" placeholder="username" value=<?=$username?> >
            <h5 class="text-danger"><?=$ereusername?></h5>
            <h5 class="text-danger"><?=$erename?></h5>
            
            <label class="text-left  ml-5    text-info size">Telephone</label>  
            <input type="text" class="fadeIn second" name="num_tel" placeholder="Telephone" value=<?=$num_tel?> >
            <h5 class="text-danger"><?=$erenum_tel?></h5>
            
          </div>
          <div class="marg1">
          <label class="text-left  ml-5    text-info size"> Mot de passe</label>  
            <input type="password" class="fadeIn second" name="password" placeholder="password" value=<?=$password?> >
            <h5 class="text-danger"><?=$erepassword?></h5>

            <label class="text-left  ml-5    text-info size">Confirmer Mot de passe</label>  
            <input type="password" class="fadeIn second" name="Confirmer" placeholder="Confirmation" value=<?=$Confirmer?> >
            <h5 class="text-danger"><?=$ereConfirmer?></h5>
            
           
            </div>
            </div>
            <input type="submit" class="fadeIn fourth mt-3" value="valider">
            <h5 class="text-info"><?=$message?></h5>
          
        </form>
</div>
</body>
</html>