<?php
    SESSION_START();

    if(!isset($_SESSION['admin']))
    {
    header("Location:login.php");
    }

    require("../tcpdf/tcpdf.php");
    require("bd.php");
    if(!isset($_GET['id_i']))
    {
    header("Location:index.php");
    }
    $id=$_GET['id_i'];
    $query="SELECT * FROM fac.service inner join fac.intervention on id_ser=idservice
            inner JOIN fac.user on id=id_user where id_int=:id";
    $stat=$con->prepare($query);
    $stat->execute(
      array(':id'=>$id)
    );
    $data=$stat->fetch();


//Création d'un nouveau doc pdf (Portrait, en mm , taille A5)
$pdf = new TCPDF('P', 'mm','A4');

// set some language dependent data:


// set some language-dependent strings (optional)

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//Ajouter une nouvelle page
$pdf->AddPage('A4');


// entete
$pdf->SetFont('aefurat', 'b', 13);

$pdf->Image('../image/fso.png',  130, NULL, 80, 40);
$pdf->Ln(5);
$pdf->cell(18);
$pdf->Write(5,"UNIVERSITE MOHAMED PREMIER\n");

$pdf->cell(18);
$pdf->Write(5,"FACULTE DES SCIENCES\n");

$pdf->cell(18);
$pdf->Write(5,"OUJDA\n");
//------------------
$pdf->SetFont('aefurat', '', 12);
$pdf->Ln(3);
$pdf->cell(18);
$pdf->Write(5,"Service Informatique");

// Saut de ligne
$pdf->SetFont('dejavusans', 'B', 12);

$pdf->Ln(11);
$pdf->cell(55);
$pdf->Write(5,"Fiche d'intervention Informatique\n");

$pdf->SetFont('aefurat', '', 10);
$pdf->SetMargins(20,0, 20, true);

//-----------------------
$pdf->Ln(6);
$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"NOM :  ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["username"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(50);
$pdf->Write(5,"DEPARTEMENT/SERVICE : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["service"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"TYPE DE MATÉRIEL : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["type_mat"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(32);
$pdf->Write(5,"Nº D'INVENTAIRE :");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["num_mat"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"Nº DE TELEPHONE : ");
$pdf->SetFont('aefurat', '', 10);
$pdf->Write(5,$data["num_tel"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(25);
$pdf->Write(5,"Nº D'INTERVENTION : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["code"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"Lieu D'AFFECTATION : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["lieu"]);
$pdf->Ln(10);


$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(6,"DÉSCRIPTIF SOMMAIRE DE LA PANNE : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(6,$data["descriptif"]."\n");

$pdf->SetFont('freesans', '', 12);
$pdf->Ln(8);
$pdf->cell(110);
$pdf->Write(5,"Le ".date("d-m-Y h:i")."\n");

//------------------------------------------------------------------------------------------------
$pdf->Ln(45);
$pdf->SetMargins(11.5,0, 11.5, true);
//---------------------------------------------------------------------------------------------------
// entete
$pdf->SetFont('aefurat', 'b', 13);

$pdf->Image('../image/fso.png',  130, NULL, 80, 40);
$pdf->Ln(5);
$pdf->cell(18);
$pdf->Write(5,"UNIVERSITE MOHAMED PREMIER\n");

$pdf->cell(18);
$pdf->Write(5,"FACULTE DES SCIENCES\n");

$pdf->cell(18);
$pdf->Write(5,"OUJDA\n");
//------------------
$pdf->SetFont('aefurat', '', 12);
$pdf->Ln(3);
$pdf->cell(18);
$pdf->Write(5,"Service Informatique");

// Saut de ligne
$pdf->SetFont('dejavusans', 'B', 12);

$pdf->Ln(11);
$pdf->cell(55);
$pdf->Write(5,"Fiche d'intervention Informatique\n");

$pdf->SetFont('aefurat', '', 10);
$pdf->SetMargins(20,0, 20, true);

//-----------------------
$pdf->Ln(6);
$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"NOM :  ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["username"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(50);
$pdf->Write(5,"DEPARTEMENT/SERVICE : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["service"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"TYPE DE MATÉRIEL : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["type_mat"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(32);
$pdf->Write(5,"Nº D'INVENTAIRE :");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["num_mat"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"Nº DE TELEPHONE : ");
$pdf->SetFont('aefurat', '', 10);
$pdf->Write(5,$data["num_tel"]);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(25);
$pdf->Write(5,"Nº D'INTERVENTION : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["code"]."\n");
$pdf->Ln(4);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(5,"Lieu D'AFFECTATION : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["lieu"]);
$pdf->Ln(10);


$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(20);
$pdf->Write(6,"DÉSCRIPTIF SOMMAIRE DE LA PANNE : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(6,$data["descriptif"]."\n");

$pdf->SetFont('freesans', '', 12);
$pdf->Ln(8);
$pdf->cell(110);
$pdf->Write(5,"Le ".date("d-m-Y h:i")."\n");

//Afficher le pdf
$pdf->Output();
?>



