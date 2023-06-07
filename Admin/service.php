<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    

    <title>Thème</title>
</head>
<body>
    <?php
        SESSION_START();
        
        $nom="";
        $eror="";
        require "bd.php";
        
        if(!isset($_SESSION['admin']))
        {
          header("Location:login.php");
        }
          //code ajouter--------
          if(isset($_POST['nom']) and !isset($_GET['id']) ){

            
            $nom=$_POST['nom'];
            if(empty($nom) )
            {
              $eror="nom est obligatoire <br>";
            }
            else{
              $query="SELECT * FROM service where service = :num";
              $stat=$con->prepare($query);
              $stat->execute(array(":num"=>$nom));
              $data=$stat->fetch();
              if(!$data){

              $query="INSERT INTO service values (NULL,:nom)";
              $stat=$con->prepare($query);
              $stat->execute(
                array(':nom' => $nom)
              );
            }
            else{
              $eror="nom de service deja existe <br>";
            }
        }
      }
          //code modifier--------
          if(isset($_GET['id']))
          {
            $id=$_GET['id'];
            $query="SELECT * FROM service where idservice=:id";
            $stat=$con->prepare($query);
            $stat->execute(array(":id"=>$id));
            $data=$stat->fetch();
            
            $nom=$data['service'];
            
            if(isset($_POST['nom']))
            {
              
              $nom=$_POST['nom'];
             

              $query=" UPDATE service SET service = :nom WHERE idservice=:id";
              $stat=$con->prepare($query);
              $stat->execute(
                array(":nom"=>$nom,":id"=>$id)
              );
              header("Location: service.php");
            }
          }
          

          require "menu.html";

    ?>
<div class="  d-flex justify-content-center  marg text-center">
        <form method="post" class="py-3" id="formContent" action="#">

    
        <label class="d-flex flex-column text-left ml-5  text-info size"> Service</label>
        <input type="text" name="nom" value="<?= $nom ?>" placeholder="Service"/>

      

    <P><?= $eror ?>

    <input type="submit" class=" mt-5" value="ajouter">

  </form>
</div>

<div class="m-3">
        <table id="example" class="table table-striped table-bordered " style="width:100%">
        <thead >
        <tr >
          <td class="text-center">Action</td>
          <td class="text-center">  Service </td>
          




        </tr>
        </thead>
        <tbody>
        <?php
          $query="SELECT * FROM service";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          {
            ?>
            <tr class="text-center">
              <td class="d-flex justify-content-center"><a class="btn btn-danger m-1" href="delete.php?id=<?=$row['idservice']?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service \nTous les interventions de ce service vont étre suprimer')"> <img src="../image/pas_encore.png"style="width:25px"></a>
            <a class="btn btn-warning m-1" href="service.php?id=<?=$row['idservice']?>"><img src="../image/update.png" style="width:25px"></a></td>
            <td><?=$row['service']?></td>
            

          </tr>
            <?php
          }
        ?>
        </tbody>
        
          </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

 <script>
  $(document).ready(function () {
    $('#example').DataTable();
});
   </script>
</body>
</html>