<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin/style.css">
    <title>Demande d'Intervention</title>
    <?php
        SESSION_START();

        if(!isset($_SESSION['login']))
        {
        header("Location:login.php");
        }
        
        require "menu.html";
        require "bd.php";
        $eror_t="";
        $eror_s="";
        $eror_n="";
        $eror_l="";
        $eror_d="";
        $service="";
        $type="";
        $Numero="";
        $lieu="";
        $Descriptif=""; 
        if(isset($_POST["type"]))
        {
            $service=$_POST["Service"];
            $type=$_POST["type"];
            $Numero=$_POST["Numero"];
            $lieu=$_POST["lieu"];
            $Descriptif=$_POST["Descriptif"];
            $bool=0;
            if(empty($service) )
            {
              $eror_s="Service est obligatoire <br>";
              $bool=1;
            }
            if(empty($type) )
            {
              $eror_t="Type est obligatoire <br>";
              $bool=1;
            }
            if(empty($Numero) )
            {
              $eror_n="Numero est obligatoire <br>";
              $bool=1;
            }
            if(empty($lieu) )
            {
              $eror_l="lieu est obligatoire <br>";
              $bool=1;
            }
            if(empty($Descriptif) )
            {
              $eror_d="Descriptif est obligatoire <br>";
              $bool=1;
            }
            if($bool==0){

              $query_m="SELECT MAX(code) as max FROM fac.intervention";
              $stat_m=$con->prepare($query_m);
              $stat_m->execute();
              $data_m =$stat_m->fetch();
              if($data_m["max"] == NULL)
              {
                $data_m["max"]="0_".date("Y");
              }
              
              $code_d=explode("_",$data_m["max"]);
              $code=$code_d[0]+1;
              $code.="_".date("Y");

              $query="INSERT INTO intervention values (NULL,:typ,:numero,:lieu,:dat,:code,:descriptif,:id_ser,:id_user,:statut,NULL)";
              $stat=$con->prepare($query);
              $stat->execute(
                array(':typ' => $type,
                      ':numero'=>$Numero,
                      ':lieu'=>$lieu,
                      ':dat'=>date('y-m-d'),
                        ':code'=>$code,
                        ':descriptif'=>$Descriptif,
                        ':id_ser'=>$service,
                        ':id_user'=> $_SESSION['login'],
                        ':statut'=>"attente" )
              );
            }
            
        }    

    ?>
</head>
<body>
<div class="  d-flex justify-content-center  marg marg2 text-center">
        <form method="post" class="py-2" id="formContent" action="#">
        <div class="py-2 flex mt-3">
          <div class="marg1">
            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Département/Service</label>  
            <select name="Service" class="fadeIn second">
                    <option value="" class="text-center">Département/Service</option>
                    <?php
                    $query="SELECT * from service";
                    $statement=$con->prepare($query);
                    $statement->execute();
                    $data =$statement->fetchall();
                    foreach($data as $row)
                    {
                    ?>
                        <option value="<?=$row["idservice"]?>" class="text-center"><?=$row["service"]?></option>
                    <?php
                    }
                    ?>
            </select>
            <h5 class="text-danger"><?= $eror_s ?></h5>


            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Type de matériel</label>  
            <input type="text"  class="fadeIn second" name="type" placeholder="Type de matériel" value=<?=$type?>  >
            <h5 class="text-danger"><?= $eror_t ?></h5>
            </div>
          <div class="marg1">

            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Numero d'inventaire</label>  
            <input type="text"  class="fadeIn second" name="Numero" placeholder="Numero d'inventaire" value=<?=$Numero?>  >
            <h5 class="text-danger"><?= $eror_n ?></h5>


            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">lieu d'affectation</label>  
            <input type="text"  class="fadeIn second" name="lieu" placeholder="lieu d'affectation" value=<?=$lieu?>  >
            <h5 class="text-danger"><?= $eror_l ?></h5>
            </div>
            </div>
            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size">Déscriptif sommaire de la panne</label>  
            <input type="text"  class="fadeIn second" name="Descriptif" placeholder="Déscriptif sommaire de la panne" value=<?=$Descriptif?>  >
            <h5 class="text-danger"><?= $eror_d ?></h5>


            <input type="submit" class="fadeIn fourth mt-3" value="valider">

        </form>
</div>

</body>
</html>