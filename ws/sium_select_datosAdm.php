<?php
session_start();
require_once('conecta.php');
$verifica=0;
/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */
$datosU= array();
$resultados = array();

mysqli_select_db($conecta,$database_conecta);
$query_datos = "SELECT * FROM tbl_administracion";
$datos = mysqli_query($conecta,$query_datos) or die(mysqli_error($conecta));

$totalRows_datos = mysqli_num_rows($datos);
if($totalRows_datos>0)
{
	if ($row_datos = mysqli_fetch_assoc($datos)) {
		$datosU[]=array('id_administracion'=> $row_datos['id_administracion'],
					'header'=> $row_datos['header'],
					'titulo'=> $row_datos['titulo'],
					'sub_titulo'=> $row_datos['sub_titulo'],
					'tiempo_act'=> $row_datos['tiempo_act']);	

		$resultados["mensaje"] = "Validacion Correcta";
		$resultados["validacion"] = "ok";
		$resultados["datosU"]=$datosU;
	}
}else{
	$resultados["mensaje"] = "No se Encontraron Datos";
	$resultados["validacion"] = "error";
	$resultados["datosU"] = $query_datos;
}

$resultadosJson = json_encode($resultados);


echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';


			header('Content-type: application/json');
			
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");


?>