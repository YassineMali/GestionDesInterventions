<?php
    SESSION_START();
    if(isset($_SESSION['admin']))
    {   
        require "bd.php";
        $id = $_GET['id'];
        
        $query="DELETE FROM service WHERE  idservice=:id";
        $stat=$con->prepare($query);
        
        $stat->execute(array(":id"=>$id));
        header("Location:service.php");
    }

?>