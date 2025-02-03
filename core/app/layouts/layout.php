<!DOCTYPE html>
<?php
$user = UserData::getLoggedIn();
// Verifica si el usuario está logueado
if (isset($_SESSION['user_id'])) {
  // Obtiene el usuario logueado
  $user = UserData::getLoggedIn();
  
  // Verifica si se recuperó el usuario correctamente
  if ($user) {
    $get_name = htmlspecialchars($user->name); // Escapa el nombre para evitar XSS
  } else {
    $get_name = 'Desconocido'; // Valor por defecto si no se encuentra el usuario
  }
} else {
  $get_name = 'Invitado'; // Valor por defecto si no hay usuario logueado
}
$modules = ModuleData::getAll();
?>
<html>

<head>
<meta charset="UTF-8">
<title>Cecy Covarrubias</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=0.9, maximum-scale=0.9, minimum-scale=0.9">
<link rel="icon" href="assets/4.png">

<!-- Jquery -->
<script src="assets/jquery-2.1.1.min.js" type="text/javascript"></script>

<!-- Bootstrap 3.3.4 -->
<link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome Icons -->
<link href="plugins/font-awesome/css/all.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="plugins/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<!--link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css"-->
<link href="plugins/colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css">

<!-- SweetAlert -->
<link href="plugins/sweetalert/min.css" rel="stylesheet" type="text/css" />
<script src="plugins/sweetalert/min.js"></script>



<script src="plugins/jquery/jquery-2.1.4.min.js"></script>
<script src="plugins/morris/raphael-min.js"></script>
<script src="plugins/morris/morris.js"></script>
<link rel="stylesheet" href="plugins/morris/morris.css">
<link rel="stylesheet" href="plugins/morris/example.css">
<script src="plugins/jspdf/jspdf.min.js"></script>
<script src="plugins/jspdf/jspdf.plugin.autotable.js"></script>

<?php if (isset($_GET["view"]) && $_GET["view"] == "sales") : ?>
  <script type="text/javascript" src="plugins/jsqrcode/llqrcode.js"></script>
  <script type="text/javascript" src="plugins/jsqrcode/webqr.js"></script>
  <?php endif; ?>
  
  <!-- Sweet Alert -->
  <script src="plugins/sweetalert/min.js"></script>
  <!--  Sweet Alert-->
  <!-- ColorPicker -->
  <script src="plugins/colorpicker/dist/js/bootstrap-colorpicker.js"></script>
  <!-- ColorPicker -->
  <!-- Select2 -->
  <link href="plugins/select2/select2.min.css" rel="stylesheet" />
  <script src="plugins/select2/select2.min.js"></script>
  <!-- Select2 -->
  <!-- CALENDAR-->
  <script src='assets/js/moment.min.js'></script>
  <script src='assets/js/jquery-ui.min.js'></script>
  
  <script src='node_modules/fullcalendar/index.global.min.js'></script>
  <script src='node_modules/@fullcalendar/core/locales-all.global.js'></script>
  <!-- CALENDAR -->
  
  <!--AUTOCOMPLETE JQUERY UI-->
  <!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  
  </head>
  <style>
body {
    zoom: 0.90;
    background-color: white; 
}
    .menu{
      background-color: #52768c;
    }
    .navbar {
  background-color: #52768c; /* Fondo para la barra superior */
}

.content-wrapper {
  background-color: #ffffff; /* Fondo para el contenido principal */
  
}
  </style>
<body  onload='' class="<?php if (isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])) : ?> menu   sidebar-mini <?php else : ?>login-page<?php endif; ?>">
    <div class="background" >
    <div class="wrapper">
    <!-- Main Header -->
    <?php if (isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])) : ?>
      <header class="main-header" >
      
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation" style="background-color: white;" >
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><i class="fas fa-bars" style="color: black;"></i>
      <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu" style="background-color: #black;">
      <ul class="nav navbar-nav">
      
      <!-- User Account Menu -->
      <img src="assets/logo-spa-coach-removebg-preview.png" width="120" height="50" style="margin-right: 40px; margin-top: 8px; margin-left:5px;">

      <li class="dropdown user user-menu">
      <!-- Menu Toggle Button -->
      
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <!-- The user image in the navbar-->
      <!-- hidden-xs hides the username on small devices so only the image appears. -->
      <span class="" style="color: black;"><i class="fas fa-user"style="color: black;"></i> <?php echo  $get_name ?> </span>
      </a>
      </li>
      <li class="dropdown user user-menu">
      <!-- Menu Toggle Button -->
      <a href="./logout.php" class="dropdown-toggle" style="color: black;">Salir <i class="fas fa-sign-out-alt" style="color: white;"></i></a>
      </li>
      <!-- Control Sidebar Toggle Button -->
      </ul>
      </div>
      </nav>
      </header>
      <br>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar"  >
      
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar" >
      
      <!-- ---------------------------Sidebar Menu  ADMINISTRADOR------------------------------------------>
      <ul class="sidebar-menu">
  
  <?php if ((isset($_SESSION["user_id"])) && ($_SESSION['typeUser'] == "su")) : ?>
    <meta charset="UTF-8">
   
    <li class="treeview">
        <br>
        <a href="#"><i class="fa-solid fa-handshake-simple" style="color: white;"></i> <span style="color: white;">Bienvenida</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=bienvenida/index" style="color: white;">Bienvenida</a></li>
            <li><a href="./?view=bienvenida/edit" style="color: white;">Editar</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#"><i class="fa-solid fa-house-user" style="color: white;"></i> <span style="color: white;">Introducción</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=introduccion/index" style="color: white;">Introducción</a></li>
            <li><a href="./?view=introduccion/edit" style="color: white;">Editar</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#"><i class="fa-solid fa-users" style="color: white;"></i> <span style="color: white;">Alumnos</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=alumnos/add" style="color: white;">Agregar alumnos</a></li>
            <li><a href="./?view=alumnos/index" style="color: white;">Lista de alumnos</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#"><i class="fa-solid fa-book-open-reader" style="color: white;"></i> <span style="color: white;">Contenido temático</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=temario/index" style="color: white;">Temario</a></li>
            <li><a href="./?view=mapa/index" style="color: white;">Mapa de sitio</a></li>
            <li><a href="./?view=evaluacion/index" style="color: white;">Forma de evaluación</a></li>
            <li><a href="./?view=glosario/index" style="color: white;">Glosario</a></li>
            <li><a href="./?view=fuentes/index" style="color: white;">Fuentes</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#"><i class="fa-solid fa-calendar-days" style="color: white;" > </i>  <span style="color: white;">Calendario de actividades</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=calendario/index" style="color: white;">Calendario</a></li>
            <li><a href="./?view=calendario/edit" style="color: white;">Editar calendario</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="./?view=contacto/index"><i class="fa-solid fa-address-book"  style="color: white;"> </i> <span style="color: white;">Contacto</span></a>
    </li>

    <li class="treeview">
    <a href="#"><i class="fa-solid fa-book-open-reader" style="color: white;"></i> 
        <span style="color: white;">Diplomado Electroestética</span> 
        <i class="fa fa-angle-left pull-right" style="color: white;"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="./?view=diplomado/modulos/index" style="color: white;">Administrar módulos</a></li>
        <li><a href="./?view=diplomado/materias/index" style="color: white;">Administrar materias</a></li>
        <li><a href="./?view=diplomado/temas/index" style="color: white;">Administrar temas</a></li>
        <li class="treeview">
            <?php if(count($modules) > 0): ?>
                <?php foreach($modules as $module): ?>
                    <a href="#" style="color: white; display: flex; justify-content: space-between; align-items: center;">
                        <span><?php echo $module->nombre_modulo; ?></span>
                        <i class="fa fa-angle-left" style="color: white;"></i>
                    </a>
                    <?php 
// Obtener las materias del módulo actual
$materias = MateriaData::getByModuleId($module->id);
?>

<ul class="treeview-menu">
    <?php if(count($materias) > 0): ?>
        <?php foreach($materias as $materia): ?>
            <li>
                <a href="./?view=diplomado/temas/details&id=<?php echo $materia->id; ?>" style="color: white;">
                    <?php echo htmlspecialchars($materia->nombre_materia); ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>
            <a href="#" style="color: white;">No hay materias disponibles.</a>
        </li>
    <?php endif; ?>
</ul>

                <?php endforeach; ?>
            <?php else: ?>
                <a href="#" style="color: white;">No hay módulos disponibles.</a>
            <?php endif; ?>
        </li>
    </ul>
</li>


    <!-- Aquí comienza el nuevo elemento de menú, fuera del árbol de "Diplomado Electroestética" -->
    <li class="treeview">
        <a href="./?view=contenidoDinamico/index">
            <i class="fa-regular fa-newspaper" style="color: white;"></i> 
            <span style="color: white;">Recursos adicionales</span> 
        </a>
    </li>

    <li class="treeview">
        <a href="#"><i class='fas fa-cog' style="color: white;"></i> 
            <span style="color: white;">Configuración</span> 
            <i class="fas fa-angle-left pull-right" style="color: white;"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="./?view=configuration/edit-clinic-profile" style="color: white;">Perfil</a></li>
            <?php if (isset($medic)) : ?>
                <li><a href="./?view=configuration/edit-medic-profile" style="color: white;">Perfil de Usuarios</a></li>
            <?php endif; ?>
            <li><a href="./?view=users/index" style="color: white;">Usuarios</a></li>
        </ul>
    </li>

</ul>

<?php endif; ?>


















          <ul class="sidebar-menu">
      
      <?php if ((isset($_SESSION["user_id"])) && ($_SESSION['typeUser'] == "a")) : ?>
        <meta charset="UTF-8">
        
        <li class="treeview">
        <br>
        <a href="./?view=bienvenida/index" style="color: white;"><i class="fa-solid fa-handshake-simple" style="color: white;" ></i> <span style="color: white;">Bienvenida</span> </a>
      
        </li>
        
        
        <li class="treeview">
        <a href="./?view=introduccion/index"><i class="fa-solid fa-house-user" style="color: white;"></i> <span style="color: white;">Introducción</span> </a>
       
        </li>
        
        <li class="treeview">
        <a href="./?view=alumnos/add"><i class="fa-solid fa-users" style="color: white;"></i> <span style="color: white;">Registrate</span> </a>
      </li>
      <li class="treeview">
        <a href="#"><i class="fa-solid fa-book-open-reader" style="color: white;"></i> 
            <span style="color: white;">Diplomado Electroestética</span> 
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
        </a>
        <ul class="treeview-menu">
    <li class="treeview">
        <?php if(count($modules) > 0): ?>
            <?php foreach($modules as $module): ?>
                <a href="materias.php?id=<?php echo $module->id; ?>" 
                   style="color: white; display: flex; justify-content: space-between; align-items: center;">
                    <span><?php echo $module->nombre_modulo; ?></span>
                    <i class="fa fa-angle-left" style="color: white;"></i>
                </a>
                <ul class="treeview-menu">
                    <?php 
                    // Obtener las materias del módulo actual
                    $materias = MateriaData::getByModuleId($module->id);
                    ?>
                    <?php if(count($materias) > 0): ?>
                        <?php foreach($materias as $materia): ?>
                            <li>
                                <a href="./?view=diplomado/materias/materias-alumno&id=<?php echo $materia->id; ?>" style="color: white;">
                                    <?php echo $materia->nombre_materia; ?>
                                </a>

                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <a href="#" style="color: white;">No hay materias disponibles.</a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endforeach; ?>
        <?php else: ?>
            <a href="#" style="color: white;">No hay módulos disponibles.</a>
        <?php endif; ?>
    </li>
</ul>

    </li>
      <li class="treeview">
        <a href="#"><i class="fa-solid fa-book-open-reader" style="color: white;"></i> <span style="color: white;">Contenido temático</span> <i class="fa fa-angle-left pull-right" style="color: white;"></i></a>
        <ul class="treeview-menu">
            <li><a href="./?view=temario/index" style="color: white;">Temario</a></li>
            <li><a href="./?view=mapa/index" style="color: white;">Mapa de sitio</a></li>
            <li><a href="./?view=evaluacion/index" style="color: white;">Forma de evaluación</a></li>
            <li><a href="./?view=glosario/index" style="color: white;">Glosario</a></li>
            <li><a href="./?view=fuentes/index" style="color: white;">Fuentes</a></li>
        </ul>
    </li>
        
        <li class="treeview">
        <a href="./?view=mapa/index"><i class='fa-solid fa-list-check' style="color: white;"></i> <span style="color: white;">Guía Visual del Curso</span> </a>
        
        </li>
        
        <li class="treeview">
        <a href="./?view=calendario/index"><i class='fa-solid fa-calendar-days' style="color: white;"></i> <span style="color: white;">Calendario de actividades</span> </a>
        
        </li>
        
        
        <li class="treeview">
        <a href="./?view=contenidoDinamico/index">
            <i class="fa-regular fa-newspaper" style="color: white;"></i> 
            <span style="color: white;">Recursos adicionales</span> 
        </a>
        </li>
        <li class="treeview">
        <a href="./?view=contacto/index"><i class="fa-solid fa-address-book"  style="color: white;"> </i> <span style="color: white;">Contacto</span></a>
    </li>
       
         <li class="treeview">
         <a href="./?view=perfil_usuario/index"><i class="fa-solid fa-user" style="color: white;"></i> <span style="color: white;">Perfil</span></a>
      </li>
         <ul class="treeview-menu">
       
          <?php endif; ?>
          </section>
          </aside>
          <?php endif; ?>
          
</body>        
          
          
          
          
          
          
          
          
          
          
         
              
              
              
              
              
              
              
              
              
              
              <!-- Content Wrapper. Contains page content -->
              <?php if (isset($_SESSION["user_id"]) || isset($_SESSION["client_id"])) : ?>
                <div class="content-wrapper">
                <div class="content">
                <?php View::load("index"); ?>
                </div>
                </div><!-- /.content-wrapper -->
                
                <footer class="main-footer">
                <div class="pull-right hidden-xs">
                </div>
                Copyright © <a href="https://www.v2technoconsulting.com" target="_blank">Techno Consulting</a> <!-- Credit: www.templatemo.com -->
                </footer>
                <?php else : ?>
                  <style>
                  body::after {
                    content: "";
                    background-image: url("assets/fondo_cecy.jpeg") !important;
                    background-size: 100% !important;
                    opacity: 1;
                    top: 0;
                    left: 0;
                    bottom: 0;
                    right: 0;
                    position: absolute;
                    z-index: -1;
                  }
                 
                  </style>
                  <div class="login-box" style="margin-top: 250px;">
                  <div class="login-box-body">
                  <form action="./?action=processLogin" method="post">
                  
                  <!--<span class="label label-primary"></span>-->
                  <div class="form-group">
                  <img src="assets/logo-spa-coach.jpeg" width="300px;">
                  </div>
                  <div class="form-group has-feedback">
                  <input type="text" name="username" required class="form-control" placeholder="Usuario" />
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                  <input type="password" name="password" required class="form-control" placeholder="Contraseña" />
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                  <div class="col-xs-12">
                  <button type="submit" style="border-radius: 8px; color: white; background-color: #52768c;" class="btn btn-block btn-flat">Acceder</button>
                  </div><!-- /.col -->
                  </div>
                  </form>
                  </div><!-- /.login-box-body -->
                  </div><!-- /.login-box -->
                  <?php endif; ?>
                  
                  </div><!-- ./wrapper -->
                  </div>
                  <!-- REQUIRED JS SCRIPTS -->
                  
                  <!-- jQuery 2.1.4 -->
                  <!-- Bootstrap 3.3.2 JS -->
                  <script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
                  <script src="plugins/dist/js/app.min.js" type="text/javascript"></script>
                  
                  <script src="plugins/datatables/jquery.dataTables.js"></script>
                  <script src="plugins/datatables/dataTables.bootstrap.js"></script>
                  
                  <!-- Locales for moment.js-->
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/locale/es.js"></script>
                  <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
                  
                  <!--script src="plugins/datatables/jquery.dataTables.min.js"></script>
                  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script-->
                  <!-- Optionally, you can add Slimscroll and FastClick plugins.
                  Both of these plugins are recommended to enhance the
                  user experience. Slimscroll is required when using the
                  fixed layout. -->
                  
                  <script type="text/javascript">
                  $(document).ready(function() {
                    //Sweet Alert
                    /*Swal.fire({
                    title: '¡Atención!',
                    text: 'Estimado usuario, tu sistema presenta un saldo vencido. Te invitamos a regularizarlo a la brevedad posible.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                    });*/
                    if ("<?php echo (isset($_GET["view"]) && $_GET["view"] != "notifications/index") ?>" == true && <?php echo $configuration["notifications_active_sms_reservations"]->value ?> == 1 && "<?php echo $availableSmsTotal ?>" > 0) {
                      sendSmsNotificationsAll();
                    }
                  });
                  
                  
                  </script>
                  
                  </html>