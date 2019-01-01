$(document).on("ready", cargarDatosAdm(), privilegio());

var fileExtension = ""; //queremos que esta variable sea global para la foto

function cargarDatosAdm() {

    archivoValidacion = ip+"ws/sium_select_datosAdm.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        
    }).done(function(respuestaServer) {
        if (respuestaServer.validacion == "ok") {
            var user = respuestaServer.datosU;
            $(".id_administracion").val(user[0].id_administracion);
            $(".in_header").val(user[0].header);
            $(".titulo").val(user[0].titulo);
            $(".subtitulo").val(user[0].sub_titulo);

            var slider = $("#sliderTime").data("ionRangeSlider");
			slider.update({

                from: user[0].tiempo_act
				// etc.
            })
        } else {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            $(".id_administracion").val("-1");
            mensajeUnico("Alerta: ", respuestaServer.mensaje);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })
}

$('.guardar').click(function(){
    var id_administracion = $(".id_administracion").val();
    var header = $(".in_header").val();
    var titulo = $(".titulo").val();
    var subtitulo = $(".subtitulo").val();
    var time = $(".time").val();

    console.log(id_administracion);
    console.log(header);
    archivoValidacion = ip+"ws/sium_sincronizar_admSistema.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        id_administracion: id_administracion,
        header: header,
        titulo: titulo,
        subtitulo:subtitulo,
        time: time
    }).done(function(respuestaServer) {

        if (respuestaServer.validacion == "ok") {
        	cargarDatosAdm();
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