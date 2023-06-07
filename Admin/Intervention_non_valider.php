<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    
    
    <title>Intervention</title>
</head>
<?php
        SESSION_START();

        if(!isset($_SESSION['admin']))
        {
        header("Location:login.php");
        }
        
        require "bd.php";
        if(isset($_GET['id_en']))
        {
            $id=$_GET['id_en'];
            $query ="UPDATE intervention SET statut = :encour WHERE id_int= :id";
            $stat=$con->prepare($query);
            $stat->execute(
                array(':encour' => "valider" ,':id' => $id)
            );
            header("Location:description.php?id=$id");

        }
        if(isset($_GET['id_pas']))
        {
            $id=$_GET['id_pas'];
            $query ="UPDATE intervention SET statut = :pasen WHERE id_int= :id";
            $stat=$con->prepare($query);
            $stat->execute(
                array(':pasen' => "en cours" ,':id' => $id)
            );
        }
        if(isset($_GET['id_at']))
        {
            $id=$_GET['id_at'];
            $query ="UPDATE intervention SET statut = :att WHERE id_int= :id";
            $stat=$con->prepare($query);
            $stat->execute(
                array(':att' => "pas encore" ,':id' => $id)
            );
        }
        require "menu.html";


?>
<body>
<div class=" m-3">
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <td class="text-center">Nom</td>
            <td class="text-center">Numéro de Téléphone</td>
            <td class="text-center">Type de Matériel</td>
            <td class="text-center">Numéro d'inventaire</td>
            <td class="text-center">lieu</td>
            <td class="text-center">Date</td>
            <td class="text-center">code</td>
            <td class="text-center">Description</td>
            <td class="text-center">Statut</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $query="SELECT * from fac.intervention  i inner join fac.user u on i.id_user = u.id where statut like 'pas encore' or statut like 'en cours' or statut like 'Attente' ORDER BY cast(SUBSTRING_INDEX(code, '_',1) as unSIGNED) asc";
          $stat=$con->prepare($query);
          $stat->execute();
          $data=$stat->fetchAll();
          foreach($data as $row)
          { 
            ?>
            <tr>
              <td><?=$row['username']?></td>
              <td><?=$row['num_tel']?></td>
              <td><?=$row['type_mat']?></td>
              <td><?=$row['num_mat']?></td>
              <td><?=$row['lieu']?></td>
              <td style="width:100px;"><?=date("d-m-Y", strtotime($row['date']))?></td>
              <td><?=$row['code']?></td>
              <td><?=$row['descriptif']?></td>
              <td class="text-center" style="width:150px;">

            <?php
             if($row['statut']=="en cours"){
            ?>
              <a class="btn btn-warning m-1 font-weight-bold " href="?id_en=<?=$row['id_int']?>" onclick="return confirm('vous voulez finlaisez cette operation')"><img src="../image/en_cours.png" style="width:35px">En Cours</a>
            <?php
             }
            if ($row['statut']=="pas encore") 
            {
            ?>
              <a class="btn btn-info m-1 font-weight-bold " href="?id_pas=<?=$row['id_int']?>" onclick="return confirm('vous voulez commencer cette operation')"><img src="../image/attente.png" style="width:35px">Réception</a>
            <?php
            }
            if ($row['statut']=="attente") 
            {
            ?>
              <a class="btn btn-danger m-1 font-weight-bold " href="?id_at=<?=$row['id_int']?>" onclick="return confirm('vous avez recepter cette appareil')"><img src="../image/pas_encore.png" style="width:35px">En Attente</a>
            <?php
            }
            ?>

            </td>
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
  $(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        "order": [],
        responsive: true
    } );
} );
   </script>

</body>
</html>