
$( "#clickIngresar" ).click(function() {
	var username = $('#username').val();
  	var password = $('#password').val();

  	archivoValidacion =  "ws/sium_select_usuario.php?jsoncallback=?"
  
         $.getJSON( archivoValidacion,{ 
          email:username,
          pass:password
        }).done(function(respuestaServer){ 
            if(respuestaServer.validacion == "ok"){
              
              var user= respuestaServer.datosU;
             //InsertarUsuario(user);
             var nombre = user[0].RAZON_SOCIAL;
             mensajeUnico("Bienvenido:",nombre);
             location.href = "pags/perfil.php";              
            }
            else{   
              //alert('Usuario y/o Contraseña Incorrectos!!');
              mensajeUnico("Error: ",respuestaServer.mensaje);
            }
          }).fail(function() {
            mensajeUnico("Error:",'No se puede conectar con el Servidor!!');
          })
});

