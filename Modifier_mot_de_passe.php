<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin/style.css">
    <title>Modifier mot de passe</title>
    <?php
        SESSION_START();

        if(!isset($_SESSION['login']))
        {
        header("Location:login.php");
        }
        
        require "menu.html";
        require "bd.php";
        $query = "SELECT * FROM user WHERE id = :id";
        $stat=$con->prepare($query);
        $stat->execute(
            array(':id' => $_SESSION['login'])
        );
        $data=$stat->fetch();
        $tele=$data['num_tel'];
        $ancien="";
        $Nouveau="";
        $Confirmer="";
        $eror_ancien="";
        $eror_Confirmer="";
        $eror_Nouveau="";
        $bool=0;
        $success="";
        if(isset($_POST["ancien"]))
        {
            $ancien=$_POST["ancien"];
            $Nouveau=$_POST["Nouveau"];
            $Confirmer=$_POST["Confirmer"];
            $tele=$_POST["tele"];
            if(empty($ancien))
            {
                $eror_ancien="Ancien mot de passe est obligatoire";
                $bool=1;
            }
            if(empty($Nouveau))
            {
                $eror_Nouveau="Nouveau mot de passe est vide";
                $bool=1;
            }
            if(empty($Confirmer))
            {
                $eror_Confirmer="Confirmation de mot de passe est obligatoire";
                $bool=1;
            }
            if($bool==0){
            $id=$_SESSION['login'];
            $query = "SELECT * FROM user WHERE id = :id AND password = :ancien";
            $stat=$con->prepare($query);
            $ancien=md5($ancien);
            $stat->execute(
                array(':id' => $id ,':ancien' => $ancien)
            );
            $data=$stat->fetchAll();
            if(count($data)==1)
            {
                if($Confirmer != $Nouveau)
                {
                    $eror_Confirmer="Ereur de confirmation de mot de passe";
                    $bool=1;
                }
                else
                {
                   
                    $query ="UPDATE user SET password = :Nouveau , num_tel = :tele
                            WHERE id= :id";
                    $stat=$con->prepare($query);
                    $Nouveau=md5($Nouveau);
                    $stat->execute(
                         array(':Nouveau' => $Nouveau ,':id' => $id,':tele'=> $tele)
                     );
                     $success="Vos information a bien été modifié";
                }
            }
            else{
                $eror_ancien="mot de passe est incorrect";
            }
            }
        }       

    ?>
</head>
<body>
<div class="  d-flex justify-content-center  marg marg2 text-center">
        <form method="post" class="py-2" id="formContent" action="#">
        <div class="py-2 flex mt-3">
          <div class="marg1">
            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">ancien mot de passe</label>  
            <input type="password"  class="fadeIn second" name="ancien" placeholder="ancien mot de passe" value=<?=$ancien?> >
            <h5 class="text-danger"><?= $eror_ancien ?></h5>

            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size"> Nouveau mot de passe</label>  
            <input type="password"  class="fadeIn second" name="Nouveau" placeholder="Nouveau mot de passe" value=<?=$Nouveau?> >
            <h5 class="text-danger"><?= $eror_Nouveau ?></h5>
            </div>
          <div class="marg1">
            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Confirmer mot de passe</label>  
            <input type="password"  class="fadeIn second" name="Confirmer" placeholder="Confirmer mot de passe" value=<?=$Confirmer?> >
            <h5 class="text-danger"><?= $eror_Confirmer ?></h5>

            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Numero de téléphone</label>   
            <input type="text"  class="fadeIn second" name="tele" placeholder="Téléphone" value=<?=$tele?> >
            </div>
            </div>
            <h5 class="text-info"><?= $success ?></h5>

            <input type="submit" class="fadeIn fourth mt-3" value="valider">

        </form>
</div>

</body>
</html>