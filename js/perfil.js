$(document).on("ready", cargarDatos(), privilegio());
$(".messages").hide();
var fileExtension = ""; //queremos que esta variable sea global para la foto

function cargarDatos() {
	var id_usuario = $('#id_usuario').val();
    //console.log(id_usuario);

    archivoValidacion = ip+"ws/sium_select_datos_usuario.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_usuario: id_usuario
    }).done(function(respuestaServer) {
        if (respuestaServer.validacion == "ok") {
        	var user = respuestaServer.datosU;
            //var nombre = user[0].NOMBRES + " " + user[0].APELLIDOS;
            $("#infoGeneral").html('<h4>'+user[0].RAZON_SOCIAL+
                                        //'<small>'+user[0].CEDULA+'</small>'+
                                        '<small>'+user[0].TELEFONOS+'</small></h4>'+
                                        '<small>'+user[0].DIRECCION+'</small></h4>');

            $(".nombres").val(user[0].RAZON_SOCIAL);
            $(".telefonos").val(user[0].TELEFONOS);
            $(".direccion").val(user[0].DIRECCION);
            $(".user").val(user[0].USUARIO);
            $(".pass").val("");
            $(".passAnt").val(user[0].CONTRASEÑA);
            $(".dato_adicional").val(user[0].DATO_ADICIONAL);

            $(".imagenPerfil").html('<img width="100%" src="'+user[0].FOTO+'" alt="Imagen de Perfil"> <i class="fa fa-user hide"></i>');            
            
        } else {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            mensajeUnico("Alerta: ", respuestaServer.mensaje);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })
}

$('.guardar').click(function(){
    var id_usuario = $("#id_usuario").val();
    var user = $(".user").val();
    var nombres = $(".nombres").val().toUpperCase();
    var telefonos = $(".telefonos").val();
    var direccion = $(".direccion").val().toUpperCase();
    var pass = $(".pass").val();
    if( pass==""){
    	pass = $(".passAnt").val();
    }

    var dato_adicional = $(".dato_adicional").val();

    archivoValidacion = ip+"ws/sium_sincronizar_usuario.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_usuario: id_usuario,
        user: user,
        pass:pass,
        nombres: nombres,
        telefono: telefonos,
        direccion: direccion,
        dato_adicional: dato_adicional,
        estado: "a"
    }).done(function(respuestaServer) {

        if (respuestaServer.validacion == "ok") {
        	cargarDatos();
        	//var user = respuestaServer.datosU;
            //var nombre = user[0].NOMBRES + " " + user[0].APELLIDOS;
            mensajeUnico("Alerta: ", respuestaServer.mensaje);
        } else {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            mensajeUnico("Alerta: ", respuestaServer.mensaje);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })

})



//función que observa los cambios del campo file y obtiene información
$(':file').change(function()
{
    //obtenemos un array con los datos del archivo
    var file = $("#imagen")[0].files[0];
    //obtenemos el nombre del archivo
    var fileName = file.name;
    //obtenemos la extensión del archivo
    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
    //obtenemos el tamaño del archivo
    var fileSize = file.size;
    //obtenemos el tipo de archivo image/png ejemplo
    var fileType = file.type;
    //mensaje con la información del archivo
    showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
});

//al enviar el formulario
$(':button').click(function(){
    //información del formulario
    var formData = new FormData($(".formulario")[0]);
    var message = ""; 
    //hacemos la petición ajax  
    $.ajax({
        url: 'subirFoto.php',  
        type: 'POST',
        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
            showMessage(message)        
        },
        //una vez finalizado correctamente
        success: function(data){
            message = $("<span class='success'>La imagen ha subido correctamente.</span>");
            showMessage(message);
            if(isImage(fileExtension))
            {
                $(".imagenPerfil").html("<img width='100%' alt='Imagen de Perfil' src='../img/perfil/"+data+"' />");
            }
        },
        //si ha ocurrido un error
        error: function(){
            message = $("<span class='error'>Ha ocurrido un error.</span>");
            showMessage(message);
        }
    });
});

function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}