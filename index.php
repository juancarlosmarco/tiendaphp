<?php  
session_start();

require('includes/conexion.php');
require('includes/funciones.php');

//Recojo la 'pagina que quiero cargar'
if(isset($_GET['p'])){
  $p=$_GET['p'];
}else{
  $p='productos.php'; //Pagina INICIAL
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plantilla de BOOTSTRAP 3 - Juan Carlos Marco</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/propio.css" rel="stylesheet">

  </head>
  <body>
    
    <section class="container">
      
      <header>
        <?php include('includes/encabezado.php'); ?>
      </header>
      <hr>

      <nav class="text-right">
        <?php include('includes/login.php'); ?>
      </nav>

      <nav>
        <?php include('includes/menu.php'); ?>
      </nav>

      <section class="row">
        <section class="col-md-8">
          <?php include('paginas/'.$p); ?>
        </section>
        <section class="col-md-4">
          <h2>
            Altas de Productos
          </h2>
          <?php echo dimeMes(date('n'), date('Y')); ?>
        </section>
      </section>

      <footer>
          <?php include('includes/pie.php'); ?>
      </footer>

    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
      //Cuando el document, este ready
      $(document).ready(function(){
        $('div#imagenes label a').click(function(event){
          event.preventDefault();
          $('div#imagenes').append('<input type="file" name="imagenes[]">');
        });
      });
    </script>

  </body>
</html>

<?php  
//5.- Desconectar de la BBDD
$conexion->close();
?>