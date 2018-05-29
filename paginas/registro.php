
<?php  
//FUNCIONALIDAD 3
//Si pulso el boton entrar, compruebo el correo y la clave

if(isset($_POST['Registrarse'])){

	$todoOK=true;
	$msgError='';
	//recojo correo y clave
	$nombre=$_POST['nombre'];
	if(strlen($nombre)<3){
		$todoOK=false;
		$msgError.='El nombre tiene que tener al menos 2 caracteres <br>';

	}
	$apellidos=$_POST['apellidos'];
	if(strlen($apellidos)<3){
		$todoOK=false;
		$msgError.='Los apellidos tiene que tener al menos 2 caracteres <br>';
	}
	$login=$_POST['login'];
	if(strlen($login)<3){
		$todoOK=false;
		$msgError.='El Login tiene que tener al menos 2 caracteres <br>';
	}
	$correo=$_POST['correo'];
	if(strlen($correo)<3){
		$todoOK=false;
		$msgError.='El correo tiene que tener al menos 2 caracteres <br>';
	}
	$clave=md5($_POST['clave']);
		if(strlen($clave)<4){
		$todoOK=false;
		$msgError.='La clave tiene que tener al menos 4 caracteres <br>';
	}



	// $sql="UPDATE usuarios SET nombre='$nombre', apellido='$apellido', login='$login', correo='$correo', clave='$clave' ";

	if($todoOK==true){
	$sql="INSERT INTO usuarios(nombre,apellidos,login,correo,password)VALUES('$nombre', '$apellidos','$login','$correo','$clave')";

	if($consulta=$conexion->query($sql)){
				//header('location:index.php?p=productos.php');
				header('Refresh: 2; url=index.php');
				?>
				<div class="alert alert-success">
					<strong>TODO OK!!</strong>
					Realizado con exito
				</div>
				<?php
			}else{
				?>
				<div class="alert alert-danger">
					<strong>ERROR!!</strong> 
					<?php echo $sql; ?>
				</div>
				<?php
			}

	}else{
		?>
		<div class="alert alert-danger">
			<strong>ERROR!!</strong> 
			<?php echo $msgError; ?>
		</div>
		<?php
	}

}else{
?>
<br><br>
<div class="d-flex justify-content-between" >
<div class="container">
        <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Regístrese en Nuestra Tienda</h3>
			 			</div>
			 			<div class="panel-body">
			    		<form role="form" action="index.php?p=registro.php" method="post">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" name="nombre" id="nombre" class="form-control input-sm" placeholder="Nombre" required>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" name="apellidos" id="apellidos" class="form-control input-sm" placeholder="Apellidos" required>
			    					</div>
			    				</div>
			    			</div>



								<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="login" name="login" id="login" class="form-control input-sm" placeholder="Login" required>
			    					</div>
			    				</div>

			    				<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="clave" name="clave" id="clave" class="form-control input-sm" placeholder="Clave" required>
			    					</div>
			    				</div>
			    				</div>

			    				<!--<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirmar Password">
			    					</div>
			    				</div>-->

			    					

			    			<div class="form-group">
			    				<input type="correo" name="correo" id="correo" class="form-control input-sm" placeholder="Introduce tu email">
			    			</div>

			    		
			    			</div>
			    			
			    			<input type="submit" value="Registrarse" name="Registrarse" class="btn btn-info btn-block">
			    		
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>
   </div>
<?php } ?>