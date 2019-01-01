<?php 
include 'seguridad.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>eSismert - Perfil</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="SISTEMA INFORMÁTICO DE ALMACENAMIENTO Y CONSULTA DE DATOS DE LA UNIDAD METEOROLÓGICA UBICADA EN EL INSTITUTO TECNOLÓGICO SUPERIOR ORIENTE" name="description" />
	<meta content="QUINTERO BONILLA GABRIELA LIZBETH" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="../plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="../css/animate.min.css" rel="stylesheet" />
	<link href="../css/style.min.css" rel="stylesheet" />
	<link href="../css/style-responsive.min.css" rel="stylesheet" />
	<link href="../css/theme/default.css" rel="stylesheet" id="theme" />

    <link href="../plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="../plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
    <link href="../plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="../plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
    <input type="text" id="id_usuario" value="<?php echo $_SESSION["ID_USUARIO"] ?>">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="perfil.php" class="navbar-brand">
						<p><img src="../img/sium-logo.png" width="3%"> Sistema Informático de la Unidad Meteorológica</p>
					</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle imagenTopPerfil" data-toggle="dropdown">
							<img src="<?php echo $_SESSION["FOTO"] ?>" alt="" />
                            <span class="hidden-xs"><?php echo $_SESSION["RAZON_SOCIAL"] ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="javascript:;">Editar Perfil</a></li>
							<!--<li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>-->
							<li class="divider"></li>
							<li><a href="salir.php">Cerrar Sesión</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image">
							<a href="javascript:;"><img src="<?php echo $_SESSION["FOTO"] ?>" alt="" /></a>
						</div>
						<div class="info">
							<P><?php echo $_SESSION["RAZON_SOCIAL"]; ?></P>
							<small>Administrador</small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav menu_sismert">
			        <!-- begin sidebar minify button -->
					
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->

			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Personaliza tu perfil <small> llena los campos vacios y obligatorios</small></h1>
			<!-- end page-header -->
			<!-- begin profile-container -->
            <div class="profile-container">
                <!-- begin profile-section -->
                <div class="profile-section">
                    <!-- begin profile-left -->
                    <div class="profile-left">
                        <!-- begin profile-image -->
                        <div class="profile-image imagenPerfil">
                            <!--<img src="../img/profile-cover.jpg" />
                            <i class="fa fa-user hide"></i>-->
                        </div>
                        <!-- end profile-image -->
                        <div class="m-b-10">
                            <!-- SUBIDA DE FOTO-->
                                <form enctype="multipart/form-data" class="formulario">
                                    <input type="hidden" name="id_usuarioFoto" value="<?php echo $_SESSION["ID_USUARIO"] ?>">
                                    <label>Cambiar Foto</label><br />
                                    <input name="archivo" type="file" id="imagen" /><br /><br />
                                    <input type="button" class="btn btn-danger btn-block btn-sm" value="Subir imagen" /><br />
                                </form>
                                <!--div para visualizar mensajes-->
                                <div class="messages"></div><br /><br />
                                <!--div para visualizar en el caso de imagen-->
                                <!--FIN SUBIDA DE FOTO-->
                        </div>

                    </div>
                    <!-- end profile-left -->
                    <!-- begin profile-right -->
                    <div class="profile-right">
                        <!-- begin profile-info -->
                        <div class="profile-info">
                            <!-- begin table -->
                            <div class="table-responsive">
                                <table class="table table-profile">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th id="infoGeneral">
                                                <!--<h4>Micheal	Meyer <small>Lorraine Stokes</small></h4>-->
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Nombres</td>
                                            <td>
                                                <input class="form-control input-sm nombres width-sm" disabled placeholder="Nombres" type="text">
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="field">Teléfonos</td>
                                            <td><input class="form-control input-sm width-sm telefonos" placeholder="Telefonos" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Dirección</td>
                                            <td><input class="form-control input-sm width-sm direccion" placeholder="Dirección del Domicilio" type="text"></td>
                                        </tr>                                                                               
                                        <tr>
                                            <td class="field">Usuario</td>
                                            <td><input class="form-control input-sm width-sm user" disabled placeholder="usuario" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Contraseña</td>
                                            <td>
                                                <input class="form-control input-sm width-sm passAnt" type="hidden">
                                                <input class="form-control input-sm width-sm pass" placeholder="Contraseña Nueva" type="password">
											</td>
                                        </tr>
										<tr>
                                            <td class="field">Datos Adicionales</td>
                                            <td><textarea class="form-control input-sm width-sm dato_adicional" placeholder="Ej: Tiene control de administrado" rows="5"></textarea></td>
                                        </tr>
                                        
                                        <tr>
                                            <td></td>
                                            <td><button class="btn btn-sm btn-danger guardar">Guardar</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table -->
                        </div>
                        <!-- end profile-info -->
                    </div>
                    <!-- end profile-right -->
                </div>
                <!-- end profile-section -->
            </div>
			<!-- end profile-container -->
		</div>
		<!-- end #content -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="../plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="../plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="../plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="crossbrowserjs/html5shiv.js"></script>
		<script src="crossbrowserjs/respond.min.js"></script>
		<script src="crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="../plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="../plugins/gritter/js/jquery.gritter.js"></script>
    <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="../js/form-plugins.demo.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <!-- ================== BEGIN COLOR PAGE LEVEL JS ================== -->
    <script src="../plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
    <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="../plugins/masked-input/masked-input.min.js"></script>
    <script src="../plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="../plugins/password-indicator/js/password-indicator.js"></script>
    <script src="../plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
    <script src="../plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="../plugins/jquery-tag-it/js/tag-it.min.js"></script>
    <script src="../plugins/bootstrap-daterangepicker/moment.js"></script>
    <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../plugins/select2/dist/js/select2.min.js"></script>
    <script src="../plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
    <script src="../plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
	<script src="../js/datos-unidad.js"></script>
	<script src="../js/perfil.js"></script>

    <script src="../js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
            FormPlugins.init();
		});
	</script>
<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>-->
</body>
</html>
