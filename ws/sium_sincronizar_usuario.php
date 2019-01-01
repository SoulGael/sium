<?php
ob_start();
require_once('conecta.php');

$id_usuario=$_GET['id_usuario'];
$user=$_GET['user'];
$pass= $_GET['pass'];
$nombre=$_GET['nombres'];
$telefono=$_GET['telefono'];
$direccion=$_GET['direccion'];
$dato_adicional=$_GET['dato_adicional'];
$estado=$_GET['estado'];

$resultados=array();

$verifica = 0;

mysqli_select_db($conecta,$database_conecta);

	if($id_usuario!="-1"){
		$query=" UPDATE `tbl_usuario` SET 
		`usuario` = '".$user."', 
		`contraseña` = '".$pass."', 
		`razon_social` = '".$nombre."', 
		`telefonos` = '".$telefono."',  
		`direccion` = '".$direccion."', 
		`dato_adicional` = '".$dato_adicional."', 
		`estado` = '".$estado."'
		WHERE `id_usuario` = ".$id_usuario." ";

		if(mysqli_query($conecta,$query)){
			$resultados["mensaje"] = "Actualizados Correctamente";
			$resultados["validacion"] = "ok";
		}else{
			$resultados["mensaje"] = "Ha ocurrido un error por favor contanctese con el Administrado del sistema.";
			$resultados["validacion"] = "notOkuPDA: ".mysqli_error($conecta);
		}

	}else{
		$query=" INSERT INTO `tbl_usuario`
		(
		  `usuario`,
		  `contraseña`,
		  `razon_social`,
		  `telefonos`,
		  `direccion`,
		  `dato_adicional`)  
		  value ('".$user."', '".$pass."', '".$nombre."', '".$telefono."', '".$direccion."', '".$dato_adicional."') ";

		if(mysqli_query($conecta,$query)){
			$resultados["mensaje"] = "Guardado Correctamente";
			$resultados["validacion"] = "ok";
			
		}else{
			$resultados["validacion"] = "notOk";	
		}
	}
	
//}

$resultadosJson = json_encode($resultados);


echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';


			header('Content-type: text/html; charset=utf-8; application/json');
			
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");


ob_end_flush();
?>

