$(document).on("ready", inicioEmpleados(), privilegio());
$(".messages").hide();
var fileExtension = ""; //queremos que esta variable sea global para la foto

function inicioEmpleados(){
	archivoValidacion = ip+"ws/sium_select_datos_usuario.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_usuario: "-1"
    }).done(function(respuestaServer) {
        /*EMPLEADOS*/
        if (respuestaServer.validacionDatosUsuario == "ok") {
            $("#tBody").empty();
            datosEmpleados = respuestaServer.datosUsuario;
            for(var i=0 in datosEmpleados) {
                $("#tBody").append("<tr>"+
                                        "<th>"+(parseInt(i)+1)+"</th>"+
                                        "<th><img height='40px' src='"+datosEmpleados[i].FOTO+"' alt='Imagen de Perfil'></th>"+
                                        "<th>"+datosEmpleados[i].RAZON_SOCIAL+"</th>"+
                                        "<th>"+datosEmpleados[i].USUARIO+"</th>"+
                                        "<th>"+datosEmpleados[i].TELEFONOS+"</th>"+
                                        "<th>"+datosEmpleados[i].DIRECCION+"</th>"+
                                        "<th>"+datosEmpleados[i].DATO_ADICIONAL+"</th>"+
                                        "<th>"+
                                            "<p><a href='#modal-message' tittle='Editar' class='btn btn-info btn-icon btn-circle btn-xs btn-edit' data-toggle='modal' onclick=editarDatos('"+datosEmpleados[i].ID_USUARIO+"')><i class='fa fa-pencil'></i></a> "+
                                            "<a class='btn btn-danger btn-icon btn-circle btn-xs'><i class='fa fa-times'></i></a></p>"+
                                        "</th>"+
                                    "</tr>");
            }
        } if (respuestaServer.validacionDatosUsuario == 'error') {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            mensajeUnico("Alerta:" , respuestaServer.mensajeDatosUsuario);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })
}

$(".new").click(function(){
    $('input[type="text"]').val('');
    $("#id_usuarioFoto").val("-1");
    $("#infoFoto").hide();
})

function editarDatos(id_usuario) {
    $("#infoFoto").show();
    $("#id_usuarioFoto").val(id_usuario);

    archivoValidacion = ip+"ws/sium_select_datos_usuario.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_usuario: id_usuario
    }).done(function(respuestaServer) {
        if (respuestaServer.validacion == "ok") {            
            var user = respuestaServer.datosU;
            //var nombre = user[0].NOMBRES + " " + user[0].APELLIDOS;
            $("#infoGeneral").html('<h4>'+user[0].RAZON_SOCIAL+
                                        //'<small>'+user[0].CEDULA+'</small>'+
                                        '<small>'+user[0].RAZON_SOCIAL+'</small></h4>'+
                                        '<small>'+user[0].TELEFONOS+'</small></h4>');
            
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
	var id_usuario = $("#id_usuarioFoto").val();
    var nombres = $(".nombres").val().toUpperCase();
    var telefonos = $(".telefonos").val();
    var direccion = $(".direccion").val().toUpperCase();
    var usuario = $(".user").val();
    var pass = $(".pass").val();
    if( pass==""){
    	pass = $(".passAnt").val();
    }

    var dato_adicional = $(".dato_adicional").val();

    archivoValidacion = ip+"ws/sium_sincronizar_usuario.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_usuario: id_usuario,
        nombres: nombres,
        telefono: telefonos,
        direccion: direccion,
        user: usuario,
        pass:pass,
        dato_adicional: dato_adicional,
        estado: "a"
    }).done(function(respuestaServer) {

        if (respuestaServer.validacion == "ok") {
        	inicioEmpleados();
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