<h2>
	Proveedores
</h2>
<hr>

<?php  

//Necesito RECOGER en qué página estoy, para mostrar unos resultado u otros

		if(isset($_GET['numeroDePagina'])){

			$numeroDePagina=$_GET['numeroDePagina'];
		}else{
			$numeroDePagina=0;
		}


//Este archivo va a recibir una accion a realizar
//si no recibe una accion, por defecto quiero LISTAR elementos
if(isset($_GET['accion'])){
	$accion=$_GET['accion'];
}else{
	$accion='listado';
}

//Pues dependiendo de $accion, la web hace una u otra cosa
switch($accion){
	////////////////////////////////////////////////////
	///////////////LISTADO /////////////////////////////////////
	////////////////////////////////////////////////////
	case 'listado':
	
		if($_SESSION['conectado']){
		?>
		<h4>
			<a href="index.php?p=proveedores.php&accion=insertar">
				Insertar
			</a>
		</h4>
		<?php } ?>
		<hr>
		<table class="table table-striped table-hover">
		<tr>
			<th>Nombre del Proveedor</th>
			<th>Acciones del proveedor</th>
		</tr>
		<?php  
		//Hacemos listado con paginacion
		//lo primero es saber el numero TOTAL de productos

		$sql="SELECT * FROM proveedores";
		$consulta=$conexion->query($sql);
		$numeroTotalDeRegistros=$consulta->num_rows;
		//Establezco cuantos registros quiero por página
		$numeroDeRegistrosPorPagina=3;  //a mano
		
		

		////// AQUI ESTABA $GET Y RECOGIA NUM DE PAGINA DE ARRIBA

		//me las apaño para hacer la consulta según el numero de pagina que le paso
		$inicioLimite=$numeroDePagina*$numeroDeRegistrosPorPagina;
		$sql="SELECT * FROM proveedores LIMIT $inicioLimite,$numeroDeRegistrosPorPagina";
		//Ejecuto la consulta, esta vezcon su LIMIT (paginado)
		$consulta=$conexion->query($sql);

		//Hacemos el bucle para recorrer los resultados
		while($registro=$consulta->fetch_array()){
			?>
			<tr>
				<td><?php echo $registro['nombreProveedor'] ?></td>
				<td>
					<a href="index.php?p=proveedores.php&accion=ver&id=<?php echo $registro['idProveedor']; ?>">Ver</a>
					<?php 
					if($_SESSION['conectado']){
					?>
					 - 
					<a href="index.php?p=proveedores.php&accion=borrar&id=<?php echo $registro['idProveedor']; ?>&numeroDePagina= <?php echo $numeroDePagina; ?>" onClick="if(!confirm('Estas Seguro?')){return false};">Borrar</a>
					 - 
					<a href="index.php?p=proveedores.php&accion=modificar&id=<?php echo $registro['idProveedor']; ?> &numeroDePagina= <?php echo $numeroDePagina; ?>">Modificar</a>
					<?php } ?>
				</td>
			</tr>
			<?php
		}
	
		?>
		</table>
		<hr>
		<div class="text-center">
			<ul class="pagination">


			<?php if($numeroDePagina==0){ ?>
				<li class="disabled"><a href="#">&laquo;</a></li>
			<?php }else{ ?>

					<li><a href="index.php?p=proveedores.php&accion=listado&numeroDePagina=<?php echo ($numeroDePagina-1); ?>">&laquo;</a></li>
			<?php } ?>

			<?php 

				  	$numeroTotalDePaginas=ceil($numeroTotalDeRegistros/$numeroDeRegistrosPorPagina); //ceil(techo) redondea hacia arriba- floor redondea hacia abajo

				  	//Uso bucle para dibujar los numero
				  	for($numPagina=0;$numPagina<$numeroTotalDePaginas;$numPagina++){
				  		if($numeroDePagina==$numPagina){
				  			$activa='active';
				  		}else{
				  			$activa='';
				  		}
				   ?>
				   	<li class="<?php echo $activa; ?>">
				   		<a href="index.php?p=proveedores.php&accion=listado&numeroDePagina=<?php echo $numPagina; ?>">
				   			<?php echo ($numPagina+1) ?>
				   				
				   		</a>
				   	</li>


				  <?php 
				  	}//fin del bucle for
				   ?>


				  <?php if($numeroDePagina==($numeroTotalDePaginas-1)){ ?>
							<li class="disabled"><a href="#">&raquo;</a></li>
					<?php }else{ ?>

							<li><a href="index.php?p=proveedores.php&accion=listado&numeroDePagina=<?php echo ($numeroDePagina+1); ?> ">&raquo;</a></li>
	
				  <?php 
				  	}//fin del bucle for
				   ?>
			</ul>
		</div>
		
		<?php
	
		break;

	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////   VER   //////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'ver':

		$id=$_GET['id'];
		$sql="SELECT * FROM proveedores WHERE idProveedor=$id";
		$consulta=$conexion->query($sql);
		$registro=$consulta->fetch_array();
		?>
		<h4>
			<a href="index.php?p=proveedores.php&accion=listado">
				Volver
			</a>
		</h4>
		<hr>
		<article>
			<div class="jumbotron">
			<div class="container">
			<h1><?php echo $registro['nombreProveedor']; ?></h1>
			
			<p><?php echo $registro['telefonoProveedor']; ?></p>
			<hr>
			<!-- <p><?php echo $registro['precioProd']; ?> Euros
			-
			<?php echo $registro['unidadesProd']; ?> Unidades Disponibles</p> -->
			<!-- <footer>Precio - disponibilidad</footer> -->
			</div>
		</div>
		</article>
		<?php

		break;

	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////  BORRAR  //////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'borrar':

	if($_SESSION['conectado']){
		$id=$_GET['id'];
		$sql="DELETE FROM proveedores WHERE idProveedor=$id";
		if($consulta=$conexion->query($sql)){
			//header('location:index.php?p=productos.php');
			header('Refresh: 2; url=index.php?p=proveedores.php&numeroDePagina=' .$numeroDePagina);
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
				No se ha podido realizar
			</div>
			<?php
		}
	}
		break;

	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////////  MODIFICAR  /////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'modificar':
	if($_SESSION['conectado']){
		if(isset($_POST['enviar'])){

			$nombreProveedor=$_POST['nombreProveedor'];
			$telefonoProveedor=$_POST['telefonoProveedor'];
			// $precioProd=$_POST['precioProd'];
			// $unidadesProd=$_POST['unidadesProd'];
			$idProveedor=$_POST['idProveedor'];
			// if(isset($_POST['activado'])){
			// 	$activado=1;//checked

			// }else{
			// 	$activado=0;//no checked-activado

			// }

			$sql="UPDATE proveedores SET nombreProveedor='$nombreProveedor', telefonoProveedor='$telefonoProveedor' WHERE idProveedor='$idProveedor'";

			if($consulta=$conexion->query($sql)){
				//header('location:index.php?p=productos.php');
				header('Refresh: 2; url=index.php?p=proveedores.php');
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

			$id=$_GET['id'];
			$sql="SELECT * FROM proveedores WHERE idProveedor=$id";
			$consulta=$conexion->query($sql);
			$registro=$consulta->fetch_array();
		
			?>
			<form action="index.php?p=proveedores.php&accion=modificar" method="post">
				
				<div class="form-group">
					<label for="nombreProveedor">Nombre del Proveedor:</label>
					<input type="text" class="form-control" name="nombreProveedor" id="nombreProveedor" value="<?php echo $registro['nombreProveedor']; ?>">
				</div>

				<div class="form-group">
					<label for="descripcionProd">Teléfono del Proveedor:</label>
					<input type="text" class="form-control" name="telefonoProveedor" id="telefonoProveedor" value="<?php echo $registro['telefonoProveedor']; ?>">
				</div>

				<!-- <div class="form-group">
					<label for="precioProd">Precio del producto:</label>
					<input type="text" class="form-control" name="precioProd" id="precioProd" value="<?php echo $registro['precioProd']; ?>">
				</div>

				<div class="form-group">
					<label for="unidadesProd">Unidades del producto:</label>
					<input type="text" class="form-control" name="unidadesProd" id="unidadesProd" value="<?php echo $registro['unidadesProd']; ?>">
				</div> -->
				<!-- <?php 
				if($registro['activado']==1){
					$checked='checked';
				}else{
					$checked='';	
				}

				 ?> -->

				<!-- div class="form-group">
						<label for="activado">Producto Activado: </label>
						<input type="checkbox" class="form-control" name="activado" id="activado" <?php echo $checked; ?>>

				</div> -->

				<input type="hidden" name="idProveedor" value="<?php echo $registro['idProveedor']; ?>">
				
				<input type="submit" class="form-control" name="enviar" value="enviar">

			</form>
			<?php
		}
	} //if($_SESSION['conectado']){	
		break;


	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////////  INSERTAR  /////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'insertar':
	if($_SESSION['conectado']){
		if(isset($_POST['enviar'])){

			$nombreProveedor=$_POST['nombreProveedor'];
			$telefonoProveedor=$_POST['telefonoProveedor'];
			// $precioProd=$_POST['precioProd'];
			// $unidadesProd=$_POST['unidadesProd'];
			// if(isset($_POST['activado'])){
			// 	$activado=1;//checked

			// }else{
			// 	$activado=0;//no checked-activado

			// }

			$sql="INSERT INTO proveedores (nombreProveedor, telefonoProveedor) VALUES ('$nombreProveedor','$telefonoProveedor')";

			if($consulta=$conexion->query($sql)){
				//header('location:index.php?p=productos.php');
				header('Refresh: 2; url=index.php?p=proveedores.php');
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
			<form action="index.php?p=proveedores.php&accion=insertar" method="post">
				
				<div class="form-group">
					<label for="nombreProveedor">Nombre del Proveedor:</label>
					<input type="text" class="form-control" name="nombreProveedor" id="nombreProveedor">
				</div>

				<div class="form-group">
					<label for="telefonoProveedor">Teléfono del Proveedor:</label>
					<input type="text" class="form-control" name="telefonoProveedor" id="telefonoProveedor">
				</div>

				<!-- <div class="form-group">
					<label for="precioProd">Precio del producto:</label>
					<input type="text" class="form-control" name="precioProd" id="precioProd">
				</div>

				<div class="form-group">
					<label for="unidadesProd">Unidades del producto:</label>
					<input type="text" class="form-control" name="unidadesProd" id="unidadesProd">
				</div>
				<div class="form-group">
						<label for="activado">Producto Activado: </label>
						<input type="checkbox" class="form-control" name="activado" id="activado" checked>

				</div> -->
				
				<input type="submit" class="form-control" name="enviar" value="enviar">

			</form>
			<?php
		}
	} //if($_SESSION['conectado']){	
		break;



} //Fin del switch($accion)
?>