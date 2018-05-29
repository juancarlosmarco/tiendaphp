

<?php  
$titulosEnlaces=['Inicio', 'Proveedores'];
$direccionEnlaces=['productos.php', 'proveedores.php'];
?>

<ul class="nav nav-tabs">
  <?php 
    for($i=0;$i<count($titulosEnlaces);$i++){ 
      if($direccionEnlaces[$i]==$p){
        $activo=' class="active"';
      }else{
        $activo='';
      }
    ?>
    <li<?php echo $activo; ?>>
    	<a href="index.php?p=<?php echo $direccionEnlaces[$i]; ?>">
        <?php echo $titulosEnlaces[$i]; ?>
      </a>
    </li>
  <?php } ?>
</ul>