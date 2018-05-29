
<?php  

//1.- Conectar a la BBDD
$servidor='localhost';
$usuario='root';
$clave='';
$base='tienda';
$conexion=new Mysqli($servidor, $usuario, $clave, $base);
$conexion->set_charset('utf8');

?>