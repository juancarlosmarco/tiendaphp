



<?php  
//FUNCIONALIDAD 1
//Si NO EXISTE LA VARIABLE de SESSION, LA CREO NULA inicialmente
if(!isset($_SESSION['conectado'])){
  // Cuando el usuario, abra la pagina, pueden pasar 2 cosas.
  //o tengo una cookie.... o no.....
  //Si tengo una cookie....
  if(isset($_COOKIE['conectado'])){
    //Recojo el valor de la cookie
    $codigo=$_COOKIE['conectado'];
    //Hago una consulta a la bbdd
    $sql="SELECT * FROM usuarios WHERE session='$codigo'";
    //si existe un usuario con ese valor, lo recojo 
    // y si no... la variable de SESSION sera NULL
    $consulta=$conexion->query($sql);
    if($registro=$consulta->fetch_array()){
      $_SESSION['conectado']=$registro;
    }else{
      $_SESSION['conectado']=null;
    } //Fin de if($_COOKIE)
  }else{
	 $_SESSION['conectado']=null;
  } //Fin de if($_SESSION)
}
?>

<?php  
//FUNCIONALIDAD 2
// si el usuario ha pulsado el enlace desconectar, cierro Session
if(isset($_GET['desconectar'])){
	$_SESSION['conectado']=null;
  setcookie('conectado', null, 0); //EXPIRO LA COOKIE
}
?>

<?php  
//FUNCIONALIDAD 3
//Si pulso el boton entrar, compruebo el correo y la clave
if(isset($_POST['entrar'])){

	//recojo correo y clave
	$correo=$_POST['correo'];
	$clave=md5($_POST['clave']);

	//Compruebo si son correctos
	$sql="SELECT * FROM usuarios WHERE correo='$correo' AND password='$clave'";
  $consulta=$conexion->query($sql);
  if($registro=$consulta->fetch_array()){
		$_SESSION['conectado']=$registro; //conecto al usuario

    //Pregunto si quiero guardar la cookie
    if(isset($_POST['recordar'])){
      //Me creo un codigo UNICO para este usuario, y lo guardo en la
      //tabla de usuarios, y en la cookie
      $codigo=md5(time()+rand(1000, 90000000));
      $sql="UPDATE usuarios SET session='$codigo' WHERE correo='$correo'";
      $consulta=$conexion->query($sql);
      setcookie('conectado', $codigo, time()+60*60*24*7);
    } //fin de si guardar una cookie

  } //fin de if($registro=.....)

} //Fin del if, de comprobar la pulsacion de ENTRAR
?>

<?php  
//FUNCIONALIDAD 4:
//Comprobar si el usuario esta o no conectado
if($_SESSION['conectado']){
	?>
	Bienvenido <?php echo $_SESSION['conectado']['nombre']; ?> <?php echo $_SESSION['conectado']['apellidos']; ?> - <a href="index.php?desconectar=desconexion">Desconectar</a>
	<?php
}else{
?>

<form class="form-inline" role="form" method="post" action="index.php">
  <div class="form-group">
    <label class="sr-only" for="correo">Email</label>
    <input type="email" class="form-control" id="correo"
           placeholder="Introduce tu email" name="correo">
  </div>
  <div class="form-group">
    <label class="sr-only" for="clave">Contraseña</label>
    <input type="password" class="form-control" id="clave" 
           placeholder="Contraseña" name="clave">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="recordar"> No cerrar sesión
    </label>
  </div>
  <button type="submit" class="btn btn-info" name="entrar">Entrar</button>
  
  - <a href="index.php?p=registro.php">Registrate</a>

</form>

<?php 
} 
?>
