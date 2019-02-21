<?php
ob_start();
require_once('ws/conecta.php');

//LECTURA DEL ARCHIVO
//http://galliguera.net/DatosClima/EXPLICACION_VARIABLES.html

	$fp = fopen("C:\WeatherLink\davison\download.txt", "r");	
	$cont =0;
	$arrayLineaAll=array();

	while(!feof($fp)){
		$cont ++;
		$linea = fgets($fp);
		if($cont>3){
			$splitLinea = explode(" ", $linea);
			//echo $linea."<br>";
			$contSplit = 0;
			$arrayLinea=array();

			for ($i = 0; $i < count($splitLinea); $i++) {
				if($splitLinea[$i]!="" && $splitLinea[$i]!="\r\n"){
					//$contSplit ++;
					//echo $contSplit.")"."$splitLinea[$i]"."<br>";
					array_push($arrayLinea, $splitLinea[$i]);
				}
			}
			array_push($arrayLineaAll, $arrayLinea);
		}
	}

//FIN LECTURA DEL ARCHIVO

//INGRESO DE DATOS
	for($i = 0; $i < count($arrayLineaAll); $i++){
		
		//CONVERSION DE FECHA
		$fecha = $arrayLineaAll[$i][0];
		$f = explode("/", $fecha);
		$fecha = $f[2]."-".$f[1]."-".$f[0]; //date
		//FIN CONVERSION DE FECHA

		//VERIABLES
		$hora = $arrayLineaAll[$i][1]; //time

		$temp_out=$arrayLineaAll[$i][2]=="---" ? "0" : $arrayLineaAll[$i][2] ; // double(10,1) Temperatura Ambiente
		$hi_temp=$arrayLineaAll[$i][3]=="---" ? "0" : $arrayLineaAll[$i][3] ; // double(10,1) temperatura ambiente máxima registrada en el período
		$low_temp=$arrayLineaAll[$i][4]=="---" ? "0" : $arrayLineaAll[$i][4] ; // double(10,1) temperatura ambiente minima registrada en el períod
		
		$solar_rad=$arrayLineaAll[$i][19]=="---" ? "0" : $arrayLineaAll[$i][19] ; //tinyint(10) Cantidad de radiación solar
		$solar_energy=$arrayLineaAll[$i][20]=="---" ? "0" : $arrayLineaAll[$i][20] ;//double(10,2) energía solar: Es el monto de la energía de la radiación solar acumulada
		$hi_solar_rad=$arrayLineaAll[$i][21]=="---" ? "0" : $arrayLineaAll[$i][21] ;//int(10) Hi Solar Rad: Radiación solar máxima alcanzada en el período.
		
		$uv_index=$arrayLineaAll[$i][22]=="---" ? "0" : $arrayLineaAll[$i][22] ;//double(10,1) 
		$uv_dose=$arrayLineaAll[$i][23]=="---" ? "0" : $arrayLineaAll[$i][23] ;//double(10,2)
		$hi_uv=$arrayLineaAll[$i][24]=="---" ? "0" : $arrayLineaAll[$i][24] ;//double(10,1)

		$out_hum=$arrayLineaAll[$i][5]=="---" ? "0" : $arrayLineaAll[$i][5] ; // double(10,1) Humedad relativa ambiente
		$hum_2nd=$arrayLineaAll[$i][36]=="---" ? "0" : $arrayLineaAll[$i][36] ;//-----NO double(10,1)
		$hum_3rd=$arrayLineaAll[$i][37]=="---" ? "0" : $arrayLineaAll[$i][37] ;//-----NO double(10,1)

		$dew_pt=$arrayLineaAll[$i][6]=="---" ? "0" : $arrayLineaAll[$i][6] ; // double(10,1) Dew Point o Punto de rocío
		$in_dew=$arrayLineaAll[$i][29]=="---" ? "0" : $arrayLineaAll[$i][29] ;//------NO double(10,1) Punto de rocio en el interior, donde se encuentra ubicada la consola

		$wind_speed=$arrayLineaAll[$i][7]=="---" ? "0" : $arrayLineaAll[$i][7] ; // double(10,1) Wind Speed: Velocidad del viento dada en metros/ segundo
		$wind_dir=$arrayLineaAll[$i][8]; 										//varchar(10) Wind Dir: Dirección del viento dada en grados; 0° a 360°
		$wind_chill=$arrayLineaAll[$i][12]=="---" ? "0" : $arrayLineaAll[$i][12] ; //double(10,1) sensación térmica: La temperatura de sensación considera cómo la velocidad del viento
		$wind_run=$arrayLineaAll[$i][9]=="---" ? "0" : $arrayLineaAll[$i][9] ; 	//------NO double(10,2) Wind Run: Es la medición del “monto” de viento que pasa por la estación
		$hi_speed=$arrayLineaAll[$i][10]=="---" ? "0" : $arrayLineaAll[$i][10] ; //------NO double(10,1) Hi Speed: Racha o velocidad de viento mas alta registrada en el período.
		$hi_dir=$arrayLineaAll[$i][11]; 										//------NO varchar(10) Hi Dir: Dirección de viento predominante durante el período.
		$wind_samp=$arrayLineaAll[$i][45]=="---" ? "0" : $arrayLineaAll[$i][45]; //------NO int(11)
		$wind_tx=$arrayLineaAll[$i][46]=="---" ? "0" : $arrayLineaAll[$i][46];	//------NO int(11)

		$heat_index=$arrayLineaAll[$i][13]=="---" ? "0" : $arrayLineaAll[$i][13] ; //double(10,1)  índice de calor: El índice de calor utiliza la temperatura y la humedad
		$thw_index=$arrayLineaAll[$i][14]=="---" ? "0" : $arrayLineaAll[$i][14] ; //double(10,1) indice THW (temperatura - humedad - viento)
		$heat_dd=$arrayLineaAll[$i][25]=="---" ? "0" : $arrayLineaAll[$i][25] ;//double(10,3) Esta variable es usada comúnmente en agricultura, en diseño y construcción de edificios y en evaluación del uso del combustible
		$cool_dd=$arrayLineaAll[$i][26]=="---" ? "0" : $arrayLineaAll[$i][26] ;//double(10,3) Cooling Degree-Days. Es el monto de enfriamiento requerido

		$thsw_index=$arrayLineaAll[$i][15]; //varchar(10) THSW (temperatura - humedad - sol - viento)
		$bar=$arrayLineaAll[$i][16]=="------" ? "0" : $arrayLineaAll[$i][16] ;//double(10,3) Presión atmosférica. El peso del aire de nuestra atmósfera

		$rain=$arrayLineaAll[$i][17]=="---" ? "0" : $arrayLineaAll[$i][17] ;//double(10,2) Rain: Cantidad de lluvia, dada en milimetro
		$rain_rate=$arrayLineaAll[$i][18]=="---" ? "0" : $arrayLineaAll[$i][18] ; //double(10,2) Rain Rate: Intensidad de la lluvia, dada en mm/hora.
		
		$in_temp=$arrayLineaAll[$i][27]=="---" ? "0" : $arrayLineaAll[$i][27] ;//------NO double(10,1)  In Temp: Temperatura en el interior, donde se encuentra ubicada la consola
		$in_hum=$arrayLineaAll[$i][28]=="---" ? "0" : $arrayLineaAll[$i][28] ;//------NO int(11) In Hum: Humedad en el interior, donde se encuentra ubicada la consol		
		$in_heat=$arrayLineaAll[$i][30]=="---" ? "0" : $arrayLineaAll[$i][30] ;//------NO double(10,1) ndice de calor en el interior, donde se encuentra ubicada la consola
		$in_emc=$arrayLineaAll[$i][31]=="---" ? "0" : $arrayLineaAll[$i][31] ;//------NO double(10,2)
		$in_air_densijty=$arrayLineaAll[$i][32]=="---" ? "0" : $arrayLineaAll[$i][32] ;//------NO double(10,4)
		$temp_2nd=$arrayLineaAll[$i][33]=="---" ? "0" : $arrayLineaAll[$i][33] ;//------NO double(10,1)
		$temp_3rd=$arrayLineaAll[$i][34]=="---" ? "0" : $arrayLineaAll[$i][34] ;//------NO double(10,1)
		$temp_4th=$arrayLineaAll[$i][35]=="---" ? "0" : $arrayLineaAll[$i][35] ;//------NO double(10,1)

		$et=$arrayLineaAll[$i][38]=="---" ? "0" : $arrayLineaAll[$i][38] ;//double(10,3) vapotranspiración. La evapotranspiración es una medida de la cantidad de vapor de agua devuelto al aire en una área dada

		$soil_1_moist=$arrayLineaAll[$i][39]; //------NO varchar(10)
		$soil_temp_1=$arrayLineaAll[$i][40];//------NO varchar(10)
		$leaf_wet_1=$arrayLineaAll[$i][41];//------NO varchar(10)
		$leaf_wet_2=$arrayLineaAll[$i][42];//------NO varchar(10)
		$leaf_temp_1=$arrayLineaAll[$i][43];//------NO varchar(10)
		$leaf_temp_2=$arrayLineaAll[$i][44];//------NO varchar(10)

		$iss_recept=$arrayLineaAll[$i][47]=="---" ? "0" : $arrayLineaAll[$i][47] ;//------NO double(10,3)
		$arc_int=$arrayLineaAll[$i][48]=="---" ? "0" : $arrayLineaAll[$i][48] ;//------NO int(11)
		//FIN CONVERSION FECHA

		$query_datos = "select id_datos from vta_datos where date='".$fecha."' and time='".$hora."' limit 5;";		
		$datos = mysqli_query($conecta,$query_datos) or die(mysqli_error($conecta));
		$totalRows = mysqli_num_rows($datos);
		if($totalRows==0){
			$query="insert into tbl_datos(date,time,temp_out,hi_temp,low_temp,out_hum,dew_pt,wind_speed,wind_dir,
			wind_run,hi_speed,hi_dir,wind_chill,heat_index,thw_index,thsw_index,bar,rain,rain_rate,solar_rad,solar_energy,
			hi_solar_rad,uv_index,uv_dose,hi_uv,heat_dd,cool_dd,in_temp,in_hum,in_dew,in_heat,in_emc,in_air_densijty,temp_2nd,
			temp_3rd,temp_4th,hum_2nd,hum_3rd,et,soil_1_moist,soil_temp_1,leaf_wet_1,leaf_wet_2,leaf_temp_1,leaf_temp_2,
			wind_samp,wind_tx,iss_recept,arc_int ) 
			values (DATE_FORMAT('".$fecha."',  '%Y/%m/%d'),
			'".$hora."',".$temp_out.",".$hi_temp.",".$low_temp.",".$out_hum.",".$dew_pt.",".$wind_speed.",'".$wind_dir."',
			".$wind_run.",".$hi_speed.",'".$hi_dir."',".$wind_chill.",".$heat_index.",".$thw_index.",'".$thsw_index."',".$bar.",
			".$rain.",".$rain_rate.",".$solar_rad.",".$solar_energy.",".$hi_solar_rad.",".$uv_index.",".$uv_dose.",".$hi_uv.",
			".$heat_dd.",".$cool_dd.",".$in_temp.",".$in_hum.",".$in_dew.",".$in_heat.",".$in_emc.",".$in_air_densijty.",
			".$temp_2nd.",".$temp_3rd.",".$temp_4th.",".$hum_2nd.",".$hum_3rd.",".$et.",'".$soil_1_moist."','".$soil_temp_1."',
			'".$leaf_wet_1."','".$leaf_wet_2."','".$leaf_temp_1."','".$leaf_temp_2."',".$wind_samp.",".$wind_tx.",
			".$iss_recept.",".$arc_int.")";
			//echo $query;
			//print_r($arrayLineaAll[$i][0]."=>".$fecha);

			if(mysqli_query($conecta,$query)){
				echo "Guardado Correctamente:".$query;
			}else{
				echo $query_datos."<br>";
				echo $query;
				echo mysqli_error($conecta);
			}
			echo "<br><br>";
		}
	}
//FIN DE INGRESO DE DATOS

ob_end_flush();
?>