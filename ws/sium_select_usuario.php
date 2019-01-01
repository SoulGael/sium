<?php
session_start();
require_once('conecta.php');
$verifica=0;
$pass =$_GET["pass"];
$email=$_GET["email"];
/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */
$datosU= array();
$resultados = array();

mysqli_select_db($conecta,$database_conecta);
$query_ciudadano = "SELECT * FROM tbl_usuario where usuario='".$email."' AND contraseña= '".$pass."' and estado='a';";
$ciudadano = mysqli_query($conecta,$query_ciudadano) or die(mysqli_error($conecta));

$totalRows_ciudadano = mysqli_num_rows($ciudadano);
if($totalRows_ciudadano>0)
{
	if ($row_user = mysqli_fetch_assoc($ciudadano)) {
		$datosU[]=array('razon_social'=> $row_user['razon_social'],
		            'id_usuario'=> $row_user['id_usuario']);	

		$_SESSION["ID_USUARIO"] = $row_user['id_usuario']; 
		$_SESSION["RAZON_SOCIAL"] = $row_user['razon_social'];
		$_SESSION["FOTO"] = $row_user['foto'];
		$_SESSION['TIEMPO']=time();

		$query=" UPDATE `tbl_usuario` SET `sesion` = '".session_id()."' WHERE `id_usuario` = '".$row_user['id_usuario']."' ";

		if(mysqli_query($conecta,$query)){
		}

		$resultados["mensaje"] = "Validacion Correcta";
		$resultados["validacion"] = "ok";
		$resultados["datosU"]=$datosU;
	}
}else{
	$resultados["mensaje"] = "Contraseña Incorrecta";
	$resultados["validacion"] = "error";
	$resultados["datosU"] = $query_ciudadano;
}

$resultadosJson = json_encode($resultados);


echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';


			header('Content-type: application/json');
			
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");


?>