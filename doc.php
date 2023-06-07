<?php
    SESSION_START();

    if(!isset($_SESSION['login']))
    {
    header("Location:login.php");
    }

    require("tcpdf/tcpdf.php");
    require("bd.php");
    if(!isset($_GET['id_i']))
    {
    header("Location:intervention.php");
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
$pdf = new TCPDF('P', 'mm','A6');

// set some language dependent data:


// set some language-dependent strings (optional)

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//Ajouter une nouvelle page
$pdf->AddPage('A6');


// entete
$pdf->SetFont('aefurat', 'b', 10);

$pdf->Image('image/fso.png',  55, 5, 0, 30);

$pdf->Write(5,"UNIVERSITE MOHAMED PREMIER\nFACULTE DES SCIENCES\nOUJDA\n");

//------------------
$pdf->SetFont('aefurat', '', 10);
$pdf->Ln(3);
$pdf->Write(5,"Service Informatique");

// Saut de ligne
$pdf->Ln(13);
$pdf->cell(18);
$pdf->Write(5,"Fiche d'intervention Informatique\n");


//-----------------------
$pdf->Ln(5);
$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(10);
$pdf->Write(5,"NOM :  ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["username"]."\n");
$pdf->Ln(2);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(10);
$pdf->Write(5,"DEPARTEMENT/SERVICE : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["service"]."\n");
$pdf->Ln(2);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(10);
$pdf->Write(5,"TYPE DE MATÉRIEL : ");
$pdf->SetFont('freesans', '', 10);
$pdf->Write(5,$data["type_mat"]."\n");
$pdf->Ln(2);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(10);
$pdf->Write(5,"Nº D'INVENTAIRE :");
$pdf->SetFont('aefurat', '', 10);
$pdf->Write(5,$data["num_mat"]."\n");
$pdf->Ln(2);

$pdf->SetFont('freesans', 'b', 10);
$pdf->cell(10);
$pdf->Write(5,"Nº DE TELEPHONE : ");
$pdf->SetFont('aefurat', '', 10);
$pdf->Write(5,$data["num_tel"]."\n");
$pdf->Ln(5);


$pdf->SetFont('freesans', 'b', 10);
$pdf->Write(5,"DÉSCRIPTIF SOMMAIRE DE LA PANNE :\n");

$pdf->SetFont('freesans', '', 10);
$pdf->cell(10);
$pdf->Write(5,$data["descriptif"]."\n");


$pdf->Ln(10);
$pdf->cell(50);
$pdf->Write(5,"Le ".date("d-m-Y h:i")."\n");


// Début en police dejavusans normale taille 10

$pdf->SetFont('dejavusans', '', 7.5);
$h=10;


//tableux
/*$html='
<style>
    
      table {
          border-collapse:collapse;

      }
      
      th,td {
          border:1px solid black;
          text-align: center; 
          padding: auto !important;

 
      }
   
      table tr th {
          background-color:rgb(216, 216, 216);
          color:black;

      }

      </style>
<table>
   
';
if(empty( $idTheme)) {
  $html.='
      <tr  style="line-height: 250%; font-size: 8px; " >
          <th width="19%">إسم الجمعية</th>
          <th width="8%">تاريخ تأسيس</th>    
          <th width="11%">العمالة أو الإقليم</th>
          <th width="19%" style="  padding: 3px;">العنوان</th>
          <th width="10%">إسم الرئيس</th>
          <th width="9%">الهاتف</th>
          <th width="15%">البريد الإلكتروني</th>   
          <th width="9%">مجال التدخل</th>
      </tr>
    
  ';
  foreach($data as $row){	
    $html .= '
        <tr  style=" line-height: 200%;">
  
        <td>'.  $row["nom"].'</td>
        <td >'.$row["date_de_creation"].'</td>
        <td >'.$row["nomProvince"].'</td>
        <td>'.$row["adresse"].'</td>
        <td >'. $row["nomPresident"].'</td>
        <td >'.$row["telefix"].'</td>
        <td >'.$row["email"].'</td>
        <td >'.$row["nomThem"].'</td>
        </tr>
        ';
  }
}
else{
  $html.='   
    <tr  style="line-height: 250%; font-size: 8px; " >
      <th width="20%">إسم الجمعية</th>
      <th width="10%">تاريخ تأسيس</th>    
      <th width="10%">العمالة أو الإقليم</th>
      <th width="20%" style="  padding: 3px;">العنوان</th>
      <th width="12%">إسم الرئيس</th>
      <th width="11%">الهاتف</th>
      <th width="16%">البريد الإلكتروني</th>
    </tr>
    
  ';
  foreach($data as $row){	
    $html .= '
        <tr  style=" line-height: 200%;">
  
        <td>'.  $row["nom"].'</td>
        <td >'.$row["date_de_creation"].'</td>
        <td >'.$row["nomProvince"].'</td>
        <td>'.$row["adresse"].'</td>
        <td >'. $row["nomPresident"].'</td>
        <td >'.$row["telefix"].'</td>
        <td >'.$row["email"].'</td>
        </tr>
        ';
  }
}




$html .= "
	</table>
	";
//WriteHTMLCell
$pdf->WriteHTML($html);	


*/




//Afficher le pdf
$pdf->Output();
?>



