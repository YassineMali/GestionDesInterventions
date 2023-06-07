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
    
    
    <title>Description</title>
    <?php
        SESSION_START();

        if(!isset($_SESSION['admin']))
        {
        header("Location:login.php");
        }
        
        require "bd.php";
    
        if(!isset($_GET['id']))
        {
            header("Location:Intervention_non_valider.php");
        }
        if(isset($_POST['text'])){
            $id=$_GET['id'];
            $text=$_POST['text'];
            $query ="UPDATE intervention SET description_adm = :t WHERE id_int= :id";
            $stat=$con->prepare($query);
            $stat->execute(
                array(':t' => $text ,':id' => $id)
            );
            header("Location:index.php");
        }    
        require "menu.html";

       
    ?>
    <body>
    <div class="  d-flex justify-content-center  marg text-center">
        <form method="post" class="py-3" id="formContent" action="#">
            <label class="d-flex flex-column text-left ml-5 mt-3 text-info size ">Description</label>
            <textarea id="text" name="text" rows="2" cols="50" class="textarea fadeIn second desc" placeholder="Description"></textarea>  
            <input type="submit" class="fadeIn fourth mt-3" value="valider">
        </form>
    </div>
    </body>

</html>