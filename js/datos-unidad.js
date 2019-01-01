var ip = "http://localhost/sium/";
var refreshIntervalId;
var time=0;

function iniciarRefresh(){
    fechaActual();
    //Fin Fecha Actual
    archivoValidacion = ip+"ws/sium_select_datosAdm.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        
    }).done(function(respuestaServer) {
        if (respuestaServer.validacion == "ok") {
            var user = respuestaServer.datosU;
            $(".in_header").html("<li>"+user[0].header+"</li>");
            $(".titulo").html(user[0].titulo+"<small>"+user[0].sub_titulo+"</small>");
            time = (user[0].tiempo_act)*1000;
            console.log("YES");
            refreshIntervalId = setInterval(fechaActual, time);
            console.log(time);
            
        } else {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            mensajeUnico("Alerta: ", respuestaServer.mensaje);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })
}
function fechaActual(){
    console.log("YES");
    //Fecha Actual
    var fecha = new Date();
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var optionsBD = { year: 'numeric', month: 'numeric', day: 'numeric' };
    $('.page-header').html(" <small>"+fecha.toLocaleDateString("es-ES", options)+"</small>");

    var d=fecha.toLocaleDateString("es-ES", optionsBD).split("/");
    var fechaBD=d[2]+"-"+d[1]+"-"+d[0];
    getDatos(fechaBD); //1216 545 registros
}

function detenerRefresh(){
    clearInterval(refreshIntervalId);
}

function buscarPorFecha(){
    detenerRefresh();
    var fecha = document.getElementById("datepicker-autoClose").value;
    //var fecha = $('#datepicker-autoClose').datepicker({ dateFormat: 'dd-mm-yy' }).val();
    //console.log(fecha);
    getDatos(fecha)
}

function getDatos(fechaBD){

    //Inicio Datos
    archivoValidacion = "ws/sium_datos_administrativos.php?jsoncallback=?"

    $.getJSON(archivoValidacion, {
        fecha: fechaBD
    }).done(function(respuestaServer) {

        //console.log(respuestaServer);
        if (respuestaServer.validacion == "ok") {
            $('#hi_temp').html(respuestaServer.hi_temp+"°C");
            $('#low_temp').html(respuestaServer.low_temp+"°C");
            $('#hi_solar_rad').html(respuestaServer.hi_solar_rad+"°C");
            $('#hi_uv').html(respuestaServer.hi_uv);
            $('#wind_dir').html(respuestaServer.wind_dir);
            
            lineCharUnica("Temperatura del Dia", "Tmp", respuestaServer.arrayTempOut, respuestaServer.arrayTime, "line-chart-Temperatura");
            lineCharDoble("Energía y Radiación Solar", "Radiación Solar", respuestaServer.arraySolarRad, "Energia Solar", respuestaServer.arraySolarEnergy, respuestaServer.arrayTime, "line-chart-solar");
            lineCharDoble("Radiación UltraVioleta", "Indice Uv", respuestaServer.arrayUvIndex, "Dosis Uv", respuestaServer.arrayUvDose, respuestaServer.arrayTime, "line-chart-uv");
            lineCharUnica("Humedad relativa ambiente", "Hum", respuestaServer.arrayOutHum, respuestaServer.arrayTime, "line-chart-humedad");
            lineCharUnica("Punto de Rocio", "Punto", respuestaServer.arrayDewPt, respuestaServer.arrayTime, "line-chart-dew-pt");
            lineCharDoble("Viento", "Velocidad del Viento", respuestaServer.arrayWindSpeed, "Sensación Termica", respuestaServer.arrayWindChill, respuestaServer.arrayTime, "line-chart-wind");
            lineCharDoble("Indices", "THSW (temperatura - humedad - sol - viento)", respuestaServer.arrayThswIndex, "THW (temperatura - humedad - viento)", respuestaServer.arrayThwIndex, respuestaServer.arrayTime, "line-chart-thw");
            lineCharDoble("Indices", "Indice Calor utiliza temperatura y humedad", respuestaServer.arrayHeatIndex, "Grado de calefacción", respuestaServer.arrayHeatDd, respuestaServer.arrayTime, "line-chart-heat");
            lineCharDoble("Indices de LLuvia", "Cantidad de Lluvia", respuestaServer.arrayRain, "Intensidad de la Lluvia", respuestaServer.arrayRainRate, respuestaServer.arrayTime, "line-chart-rain");
            lineCharUnica("Cooling Degree-Days", "Enfriamiento", respuestaServer.arrayCoolDd, respuestaServer.arrayTime, "line-chart-cooldd");
            lineCharUnica("Presión atmosférica", "Presion", respuestaServer.arrayBar, respuestaServer.arrayTime, "line-chart-bar");
            lineCharUnica("La evapotranspiración", "vapotranspiración", respuestaServer.arrayEt, respuestaServer.arrayTime, "line-chart-et");
            //for(var i=0 in datosNoticias) {
                /*var estado = datosNoticias[i].estado=='a' ? 'Activo' : 'Elimninado';
                $("#tBody").append("<tr>"+
                                        "<th>"+(parseInt(i)+1)+"</th>"+
                                        "<th><img height='40px' src="+datosNoticias[i].imagen+" alt='Imagen de Perfil'></th>"+
                                        "<th>"+datosNoticias[i].titulo+"</th>"+
                                        "<th>"+datosNoticias[i].cuerpo+"</th>"+
                                        "<th>"+estado+"</th>"+
                                        "<th>"+datosNoticias[i].fecha+"</th>"+
                                        "<th>"+
                                            "<p><a href='#modal-message' tittle='Editar' class='btn btn-info btn-icon btn-circle btn-xs btn-edit' data-toggle='modal' onclick=editarNoticia('"+datosNoticias[i].id_noticias+"')><i class='fa fa-pencil'></i></a> "+
                                            "<a class='btn btn-danger btn-icon btn-circle btn-xs'><i class='fa fa-times'></i></a></p>"+
                                        "</th>"+
                                    "</tr>");*/
            //}
        } if (respuestaServer.validacionNoticias == "error") {
            //alert('Usuario y/o Contraseña Incorrectos!!');
            mensajeUnico("Alerta: ", respuestaServer.mensajeNoticias);
        }
    }).fail(function() {
        mensajeUnico("Alerta:", 'No se puede conectar con el Servidor!!');
    })
}

function lineCharUnica(leyenda, titulo, datos, labels, idElement){

    var ctx = document.getElementById(idElement);
    //Labels va la hora
    //data van los Grados

    var borderColor = "red";

    new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{ 
              data: datos,
              label: titulo,
              borderColor: borderColor,
              fill: false
            }
          ]
        },
        options: {
          title: {
            display: true,
            text: leyenda
          }
        }
      });
      
}

function lineCharDoble(leyenda, titulo1, datos1,titulo2, datos2, labels, idElement){

    var ctx = document.getElementById(idElement);
    //Labels va la hora
    //data van los Grados

    new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{ 
              data: datos1,
              label: titulo1,
              borderColor: "red",
              fill: false
            },
            {
                data: datos2,
                label: titulo2,
                borderColor: "blue",
                fill: false
            }
          ]
        },
        options: {
          title: {
            display: true,
            text: leyenda
          }
        }
      });
      
}

function mensajeUnico(titulo,texto) {
    $.gritter.add({
      title: titulo,
      text: texto
    });
    return false
  };

function privilegio(){
    var html = '<li class="nav-header">Navegación</li>'+
                '<li class="has-sub active">'+
                  '<a href="javascript:;">'+
                    '<b class="caret pull-right"></b>'+
                    '<i class="fa fa-laptop"></i>'+
                    '<span>Administración</span>'+
                  '</a>'+
                  '<ul class="sub-menu">'+
                    '<li><a href="perfil.php">Perfil</a></li>'+
                    '<li><a href="admUsuarios.php">Adm. de Usuarios</a></li>'+
                    '<li><a href="admSistema.php">Adm. del Sistema</a></li>'+
                  '</ul>'+
                '</li>'+
                '<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>';
    $(".menu_sismert").prepend(html);
}