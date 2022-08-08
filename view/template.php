<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Examen ID90</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  


  <link rel="stylesheet" href="view/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="view/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="view/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="view/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="view/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="view/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <script src="view/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="view/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <script src="view/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="view/dist/js/adminlte.min.js"></script>
  <script src="view/bower_components/moment/min/moment.min.js"></script>
  <script src="view/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="view/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">

<?php

 if(isset($_SESSION["validarSesionBackend"]) && $_SESSION["validarSesionBackend"] === "ok"){

    $ruta = !empty($_GET["ruta"]) ? $_GET["ruta"] : 'index';
    echo '<div class="wrapper">';

    /*=============================================
     HEAD
     =============================================*/

     include "modules/head.php";

     /*=============================================
     CONTENIDO
     =============================================*/
      
      if( $ruta== "index" ||
          $ruta== "out"){

        include "modules/".$ruta.".php";

      }

     

     /*=============================================
     FOOTER
     =============================================*/

     include "modules/footer.php";


    echo '</div>';

 }else{

  include "modules/login.php";

 }
?>

</body>
</html>