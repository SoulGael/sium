<?php
ob_start();
$fecha=$_GET["fecha"];
require_once('conecta.php');
/* crea un array con datos arbitrarios que seran enviados de vuelta a la aplicacion */

/* Inicio Datos */
$resultados = array();

$hora = "";
$hi_temp = 0;
$low_temp = 100;
$hi_solar_rad = 0;
$hi_uv = 0;
$wind_dir = "";

$arrayTime= array();
$arrayTempOut= array();
$arraySolarRad= array();
$arraySolarEnergy= array();
$arrayUvIndex= array();
$arrayUvDose= array();
$arrayOutHum= array();
$arrayDewPt= array();
$arrayWindSpeed = array();
$arrayWindChill = array();
$arrayHeatIndex = array();
$arrayThwIndex = array();
$arrayHeatDd = array();
$arrayCoolDd = array();
$arrayThswIndex = array();
$arrayBar = array();
$arrayRain = array();
$arrayRainRate = array();
$arrayEt = array();

mysqli_select_db($conecta,$database_conecta);

$query_datos = "SELECT * FROM tbl_datos where date='".$fecha."';";
$datos = mysqli_query($conecta,$query_datos) or die(mysqli_error($conecta));

$totalRows_datos = mysqli_num_rows($datos);
if($totalRows_datos>0)
{
	while ($row_datos = mysqli_fetch_assoc($datos)) {
		$hora = $row_datos['time'];

		array_push($arrayTime,$hora);
		array_push($arrayTempOut,floatval($row_datos['temp_out']));
		array_push($arraySolarRad,floatval($row_datos['solar_rad']));
		array_push($arraySolarEnergy,floatval($row_datos['solar_energy']));
		array_push($arrayUvIndex,floatval($row_datos['uv_index']));
		array_push($arrayUvDose,floatval($row_datos['uv_dose']));
		array_push($arrayOutHum,floatval($row_datos['out_hum']));
		array_push($arrayDewPt,floatval($row_datos['dew_pt']));
		array_push($arrayWindSpeed,floatval($row_datos['wind_speed'])); 
		array_push($arrayWindChill,floatval($row_datos['wind_chill']));
		array_push($arrayHeatIndex,floatval($row_datos['heat_index']));
		array_push($arrayThwIndex,floatval($row_datos['thw_index']));
		array_push($arrayHeatDd,floatval($row_datos['heat_dd']));
		array_push($arrayCoolDd,floatval($row_datos['cool_dd']));
		array_push($arrayThswIndex,floatval($row_datos['thsw_index'])); 
		array_push($arrayBar,floatval($row_datos['bar']));
		array_push($arrayRain,floatval($row_datos['rain']));
		array_push($arrayRainRate,floatval($row_datos['rain_rate']));
		array_push($arrayEt,floatval($row_datos['et']));

		if($row_datos['wind_dir']!='---'){
			$wind_dir = $row_datos['wind_dir'];
		}

		if(floatval($row_datos['hi_temp'])>$hi_temp){
			$hi_temp = floatval($row_datos['hi_temp']);
		}

		if(floatval($row_datos['low_temp'])<$low_temp){
			$low_temp = floatval($row_datos['low_temp']);
		}

		if(floatval($row_datos['hi_solar_rad'])>$hi_solar_rad){
			$hi_solar_rad = floatval($row_datos['hi_solar_rad']);
		}

		if(floatval($row_datos['hi_uv'])>$hi_uv){
			$hi_uv = floatval($row_datos['hi_uv']);
		}
		
		/*$arrayTempOut[]=array('et'=> $row_datos['et']);*/
	}

	$resultados["mensaje"] = "Validacion Correcta";
	$resultados["validacion"] = "ok";

	$resultados["time"]=$hora;
	$resultados["hi_temp"]=$hi_temp;//OK
	$resultados["low_temp"] = $low_temp;//OK
	$resultados["hi_solar_rad"] = $hi_solar_rad;//OK
	$resultados["hi_uv"] = $hi_uv;//OK
	$resultados["wind_dir"] = $wind_dir;//OK

	$resultados["arrayTime"] = $arrayTime;
	$resultados["arrayTempOut"] = $arrayTempOut;//OK
	$resultados["arraySolarRad"] = $arraySolarRad;//OK
	$resultados["arraySolarEnergy"] = $arraySolarEnergy;//OK
	$resultados["arrayUvIndex"] = $arrayUvIndex;//OK
	$resultados["arrayUvDose"] = $arrayUvDose;//OK
	$resultados["arrayOutHum"] = $arrayOutHum;//OK
	$resultados["arrayDewPt"] = $arrayDewPt;//OK
	$resultados["arrayWindSpeed"] = $arrayWindSpeed;//OK
	$resultados["arrayWindChill"] = $arrayWindChill;//OK
	$resultados["arrayThwIndex"] = $arrayThwIndex;//OK
	$resultados["arrayThswIndex"] = $arrayThswIndex;//OK
	$resultados["arrayHeatIndex"] = $arrayHeatIndex;//OK
	$resultados["arrayHeatDd"] = $arrayHeatDd;//OK
	$resultados["arrayCoolDd"] = $arrayCoolDd;//OK
	$resultados["arrayBar"] = $arrayBar;//PK
	$resultados["arrayRain"] = $arrayRain;//OK
	$resultados["arrayRainRate"] = $arrayRainRate;//OK
	$resultados["arrayEt"] = $arrayEt;//OK

}else{
	$resultados["mensaje"] = "Error al obtener datos";
	$resultados["validacion"] = "error";
}
/* Fin Datos */

$resultadosJson = json_encode($resultados);


echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';

			header('Content-type: application/json');
			
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");
ob_end_flush();
?>

