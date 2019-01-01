<?php
session_start();
require_once('conecta.php');
$verifica=0;
$id_usuario=$_GET["id_usuario"];
/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */
$resultados = array();
$datosU= array();

mysqli_select_db($conecta,$database_conecta);
$query_ciudadano = "SELECT * FROM tbl_usuario where id_usuario='".$id_usuario."' ;";
$ciudadano = mysqli_query($conecta,$query_ciudadano) or die(mysqli_error($conecta));

$totalRows_ciudadano = mysqli_num_rows($ciudadano);
if($totalRows_ciudadano>0)
{
	if($row_user = mysqli_fetch_assoc($ciudadano)) {
		$datosU[]=array('USUARIO'=> $row_user['usuario'],
					'CONTRASEÑA'=> $row_user['contraseña'],
		            'RAZON_SOCIAL'=> $row_user['razon_social'],
		            'TELEFONOS'=> $row_user['telefonos'],
					'DIRECCION'=> $row_user['direccion'],
					'FOTO'=> $row_user['foto'],
		            'DATO_ADICIONAL'=> $row_user['dato_adicional'],
		            'ESTADO'=> $row_user['estado']);
		
		$resultados["mensaje"] = "Validacion Correcta";
		$resultados["validacion"] = "ok";
		$resultados["datosU"]=$datosU;
	}
}else{
	/*esta informacion se envia si la validacion falla */
	  $resultados["mensaje"] = "ID Incorrecto:".$query_ciudadano;
	  $resultados["validacion"] = "error";
}

//USUARIOS
$datosUsuario= array();
$query_datos_usuario = "SELECT * FROM tbl_usuario;";
$datos_usuario = mysqli_query($conecta,$query_datos_usuario) or die(mysqli_error($conecta));

$totalRows_datos_usuario = mysqli_num_rows($datos_usuario);
if($totalRows_datos_usuario>0)
{
	while ($row_datos_usuario = mysqli_fetch_assoc($datos_usuario)) {
		$datosUsuario[]=array('ID_USUARIO'=> $row_datos_usuario['id_usuario'],
							'USUARIO'=> $row_datos_usuario['usuario'],
							'RAZON_SOCIAL'=> $row_datos_usuario['razon_social'],
							'TELEFONOS'=> $row_datos_usuario['telefonos'],
							'DIRECCION'=> $row_datos_usuario['direccion'],
							'FOTO'=> $row_datos_usuario['foto'],
							'DATO_ADICIONAL'=> $row_datos_usuario['dato_adicional'],
							'ESTADO'=> $row_datos_usuario['estado']);
	}

	$resultados["mensajeDatosUsuario"] = "Validacion Correcta";
	$resultados["validacionDatosUsuario"] = "ok";
	$resultados["datosUsuario"]=$datosUsuario;
}else{
	$resultados["mensajeDatosUsuario"] = "Algo paso al recojer los datos del Usuario: ".$query_ciudadano;
	$resultados["validacionDatosUsuario"] = "error";
}

$resultadosJson = json_encode($resultados);


echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';


			header('Content-type: application/json');
			
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");


?>

