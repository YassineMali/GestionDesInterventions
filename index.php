<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    
    <title>Historique</title>
    <?php
        SESSION_START();

        if(!isset($_SESSION['login']))
        {
        header("Location:login.php");
        }
        
        require "menu.html";
        require "bd.php";
    ?>
    
</head>
<body>
<div class="m-3">
        <table id="example" class="table table-striped table-bordered " style="width:100%">
            <thead>
                <tr>
                    <td class="text-center">Type de Matériel</td>
                    <td class="text-center">Numéro d'inventaire</td>
                    <td class="text-center">Lieu </td>
                    <td class="text-center">Date</td>
                    <td class="text-center">Code</td>
                    <td class="text-center max">Description</td>
                    <td class="text-center">Statut</td>

                </tr>
            </thead>
            <tbody>
            <?php
                $query="SELECT * FROM intervention where id_user=:id and statut like 'valider' ORDER BY cast(SUBSTRING_INDEX(code, '_',1) as unSIGNED) desc";
                $stmt=$con->prepare($query);
                $stmt->execute(array(":id"=>$_SESSION["login"]));
                $data =$stmt->fetchall();
                foreach($data as $row)
                {
            ?>
            <tr>
                    <td><?= $row['type_mat']?></td>
                    <td><?= $row['num_mat']?></td>
                    <td><?= $row['lieu']?></td>
                    <td style="width:100px;"><?= date("d-m-Y", strtotime($row['date']))?></td>
                    <td><?= $row['code']?></td>
                    <td class="max"><?= $row['descriptif']?></td>
                    <td class="text-center">
                       <span class="text-center  d-flex">
                        <a class=" nohover btn bg-success m-1 font-weight-bold d-flex align-items-center justify-content-center"><img src="image/valider1.png" style="width:35px;">Finalisé</a>
                        <a class="btn bg-primary m-1" href="doc.php?id_i=<?=$row['id_int']?>" ><img src="image/imp.png" style="width:35px;"></a>
                       <span>
                    </td>


            </tr>

            <?php
                }
            ?>
            </tbody>
           
        </table>
</div>
</body>
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
</html>