<?php
require_once('../ws/conecta.php');
//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
    $id_usuario = $_POST['id_usuarioFoto'];;
 
    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("../img/perfil/")) 
        mkdir("../img/perfil/", 0777);
     
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../img/perfil/".$file))
    {
    	$dir="../img/perfil/".$file;
    	mysqli_select_db($conecta,$database_conecta);
    	$query=" UPDATE `tbl_usuario` SET `foto` = '".$dir."' WHERE `id_usuario` = ".$id_usuario." ";

		if(mysqli_query($conecta,$query)){
			sleep(3);//retrasamos la petición 3 segundos
       		echo $file;//devolvemos el nombre del archivo para pintar la imagen
		}else{
			sleep(3);
       		echo "Ha Ocurrido un error al subir a la base de datos";
		}
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}