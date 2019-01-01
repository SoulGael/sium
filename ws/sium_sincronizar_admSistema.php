<?php
ob_start();
require_once('conecta.php');

$id_administracion=$_GET['id_administracion'];
$header=$_GET['header'];
$titulo=$_GET['titulo'];
$subtitulo= $_GET['subtitulo'];
$time=$_GET['time'];

$resultados=array();

$verifica = 0;

mysqli_select_db($conecta,$database_conecta);

	if($id_administracion!="-1"){
		$query=" UPDATE `tbl_administracion` SET 
		`header` = '".$header."', 
		`titulo` = '".$titulo."', 
		`sub_titulo` = '".$subtitulo."', 
		`tiempo_act` = ".$time."
		WHERE `id_administracion` = ".$id_administracion." ";

		if(mysqli_query($conecta,$query)){
			$resultados["mensaje"] = "Actualizados Correctamente";
			$resultados["validacion"] = "ok";
		}else{
			$resultados["mensaje"] = "Ha ocurrido un error por favor contanctese con el Administrador del sistema.";
			$resultados["validacion"] = "notOkuPDA: ".mysqli_error($conecta);
		}

	}else{
		$query=" INSERT INTO `tbl_administracion`
		(
		  `header`,
		  `titulo`,
		  `sub_titulo`,
		  `tiempo_act`)  
		  value ('".$header."', '".$titulo."', '".$subtitulo."', ".$time.") ";

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

