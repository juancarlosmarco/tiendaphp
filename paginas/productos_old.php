<h2>
	Productos
	-

	<small>
	<form action="index.php" method="get" class="form-inline">
		<input type="text" name="palabra" value="" placeholder="Buscar...">
		<input type="submit" name="buscar" value="buscar">
		<input type="hidden" name="p" value="productos.php">
		<input type="hidden" name="accion" value="buscador">
	</form>
	</small>
</h2>

<?php  
//Necesito RECOGER en que pagina estoy, para mostrar
//unos resultados u otros
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
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'listado':
		if($_SESSION['conectado']){
		?>
		<h4>
			<a href="index.php?p=productos.php&accion=insertar">
				Insertar
			</a>
		</h4>
		<?php } ?>
		<hr>
		<table class="table table-striped table-hover">
		<tr>
			<th>Nombre del producto</th>
			<th>Acciones del producto</th>
		</tr>
		<?php 
		//Hacemos un listado con paginacion
		//Lo primero es saber el numero TOTAL		 
		$sql="SELECT * FROM productos";
		$consulta=$conexion->query($sql);
		$numeroTotalDeRegistros=$consulta->num_rows;

		//Establezco cuantos registros quiero por pagina
		$numeroDeRegistrosPorPagina=5; //a mano

		/////////////////////////////////////////////////////
		//////AQUI ESTABA ANTES LO DE $_GET['numeroDePagina']
		/////////////////////////////////////////////////////

		//Me las apaño para hacer la consulta segun el 
		// $numeroDePagina que le paso
		$inicioLimite=$numeroDePagina*$numeroDeRegistrosPorPagina;

		$sql="SELECT * FROM productos LIMIT $inicioLimite,$numeroDeRegistrosPorPagina";

		//Ejecuto la consulta, esta vez con su LIMIT (paginado)
		$consulta=$conexion->query($sql);

		//Hacemos el bucle para recorrer los resultados
		while($registro=$consulta->fetch_array()){
			?>
			<tr>
				<td>
					<?php echo $registro['nombreProd'] ?>

					(<?php echo dimeFechaCorta($registro['fechaAlta']); ?>)	
				</td>
				<td>
					<a href="index.php?p=productos.php&accion=ver&id=<?php echo $registro['idProd']; ?>">Ver</a>
					<?php 
					if($_SESSION['conectado']){
					?>
					 - 
					<a href="index.php?p=productos.php&accion=borrar&id=<?php echo $registro['idProd']; ?>&numeroDePagina=<?php echo $numeroDePagina; ?>" onClick="if(!confirm('Estas seguro?')){return false;};">Borrar</a>
					 - 
					<a href="index.php?p=productos.php&accion=modificar&id=<?php echo $registro['idProd']; ?>&numeroDePagina=<?php echo $numeroDePagina; ?>">Modificar</a>
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
				<li><a href="index.php?p=productos.php&accion=listado&numeroDePagina=<?php echo ($numeroDePagina-1); ?>">&laquo;</a></li>
			<?php } ?>
			
			<?php  
			//Calculo el numero total de paginas
			$numeroTotalDePaginas=ceil($numeroTotalDeRegistros/$numeroDeRegistrosPorPagina);
			
			//Uso un bucle para dibujar los numericos
			for($numPagina=0;$numPagina<$numeroTotalDePaginas;$numPagina++){

				if($numeroDePagina==$numPagina){
					$activa='active';
				}else{
					$activa='';
				}

			?>

			<li class="<?php echo $activa; ?>">
				<a href="index.php?p=productos.php&accion=listado&numeroDePagina=<?php echo $numPagina; ?>">
					<?php echo ($numPagina+1); ?>	
				</a>
			</li>
			
			<?php  
			} //Fin del bucle for
			?>


			<?php if($numeroDePagina==($numeroTotalDePaginas-1)){ ?>
				<li class="disabled"><a href="#">&raquo;</a></li>
			<?php }else{ ?>
				<li><a href="index.php?p=productos.php&accion=listado&numeroDePagina=<?php echo ($numeroDePagina+1); ?>">&raquo;</a></li>
			<?php } ?>


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
		$sql="SELECT * FROM productos WHERE idProd=$id";
		$consulta=$conexion->query($sql);
		$registro=$consulta->fetch_array();
		?>
		<h4>
			<a href="index.php?p=productos.php&accion=listado">
				Volver
			</a>
		</h4>
		<hr>
		<article>
			
		<div class="jumbotron">
		<div class="container">
			<h1>
				<span class="glyphicon glyphicon-film"></span> 
				<?php echo $registro['nombreProd']; ?>	
			</h1>
			<p><?php echo $registro['descripcionProd']; ?></p>
			<hr>
			<p>
				<?php echo $registro['precioProd']; ?> Euros
				 - 
				<?php echo $registro['unidadesProd']; ?> unidades disponibles
			</p>
			<h3 class="text-right">
				<strong>
				Disponible desde el 
				<?php 
					echo dimeFecha($registro['fechaAlta']);
				?>
				</strong>
			</h3>
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
			$sql="DELETE FROM productos WHERE idProd=$id";
			if($consulta=$conexion->query($sql)){
				//header('location:index.php?p=productos.php');
				header('Refresh: 2; url=index.php?p=productos.php&numeroDePagina='.$numeroDePagina);
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
		}else{
			echo 'No tienes permisos para estar aqui. Logueate....!!';
		} //fin del else de if($_SESSION['conectado'])
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

				$nombreProd=$_POST['nombreProd'];
				$descripcionProd=$_POST['descripcionProd'];
				$precioProd=$_POST['precioProd'];
				$unidadesProd=$_POST['unidadesProd'];
				$idProd=$_POST['idProd'];

				if(isset($_POST['activado'])){
					$activado=1; //Sera cuando esta checked
				}else{
					$activado=0; //Sera cuando NO ESTA checked
				}

				$fechaAlta=$_POST['fechaAlta'];

				$sql="UPDATE productos SET nombreProd='$nombreProd', descripcionProd='$descripcionProd', precioProd=$precioProd, unidadesProd=$unidadesProd, activado=$activado, fechaAlta='$fechaAlta' WHERE idProd='$idProd'";

				if($consulta=$conexion->query($sql)){
					//header('location:index.php?p=productos.php');
					header('Refresh: 2; url=index.php?p=productos.php&numeroDePagina='.$numeroDePagina);
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
				$sql="SELECT * FROM productos WHERE idProd=$id";
				$consulta=$conexion->query($sql);
				$registro=$consulta->fetch_array();
			
				?>
				<form action="index.php?p=productos.php&accion=modificar&numeroDePagina=<?php echo $numeroDePagina; ?>" method="post">
					
					<div class="form-group">
						<label for="nombreProd">Nombre del producto:</label>
						<input type="text" class="form-control" name="nombreProd" id="nombreProd" value="<?php echo $registro['nombreProd']; ?>">
					</div>

					<div class="form-group">
						<label for="descripcionProd">Descripcion del producto:</label>
						<input type="text" class="form-control" name="descripcionProd" id="descripcionProd" value="<?php echo $registro['descripcionProd']; ?>">
					</div>

					<div class="form-group">
						<label for="precioProd">Precio del producto:</label>
						<input type="text" class="form-control" name="precioProd" id="precioProd" value="<?php echo $registro['precioProd']; ?>">
					</div>

					<div class="form-group">
						<label for="unidadesProd">Unidades del producto:</label>
						<input type="text" class="form-control" name="unidadesProd" id="unidadesProd" value="<?php echo $registro['unidadesProd']; ?>">
					</div>

					<div class="form-group">
						<label for="fechaAlta">Fecha de alta:</label>
						<input type="date" class="form-control" name="fechaAlta" id="fechaAlta" value="<?php echo $registro['fechaAlta']; ?>">
					</div>

					<?php 
					if($registro['activado']==1){
						$checked='checked';
					}else{
						$checked='';
					}
					?>
					<div class="form-group">
						<label for="activado">Producto activado:</label>
						<input type="checkbox" class="form-control" name="activado" id="activado" <?php echo $checked; ?>>
					</div>

					<input type="hidden" name="idProd" value="<?php echo $registro['idProd']; ?>">
					
					<input type="submit" class="form-control" name="enviar" value="enviar">

				</form>
				<?php
			}
		}else{
			echo 'No tienes permisos para estar aqui. Logueate....!!';
		} //fin del else de if($_SESSION['conectado'])
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

				$nombreProd=$_POST['nombreProd'];
				$descripcionProd=$_POST['descripcionProd'];
				$precioProd=$_POST['precioProd'];
				$unidadesProd=$_POST['unidadesProd'];
				if(isset($_POST['activado'])){
					$activado=1; //Sera cuando esta checked
				}else{
					$activado=0; //Sera cuando NO ESTA checked
				}
				$fechaAlta=$_POST['fechaAlta'];

				$sql="INSERT INTO productos(nombreProd, descripcionProd, precioProd, unidadesProd, activado, fechaAlta)VALUES('$nombreProd', '$descripcionProd', $precioProd, $unidadesProd, $activado, '$fechaAlta')";

				//TODO: POR HACER EN INGLES
				//Recoger el ultimo id de producto insertado
				//Recorrer el vector de $_FILES['imagenes'] con las imagenes
				//por cada imagen que encontremos
				//Lo subimos a la carpeta images
				//Creamos un registro en la tabla imagenes

				if($consulta=$conexion->query($sql)){
					//header('location:index.php?p=productos.php');
					header('Refresh: 2; url=index.php?p=productos.php');
					?>
					<div class="alert alert-success">
						<strong>TODO OK!!</strong>
						<?php echo $sql; ?>
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
				<form action="index.php?p=productos.php&accion=insertar" method="post" enctype="multipart/form-data">
					
					<div class="form-group">
						<label for="nombreProd">Nombre del producto:</label>
						<input type="text" class="form-control" name="nombreProd" id="nombreProd">
					</div>

					<div class="form-group">
						<label for="descripcionProd">Descripcion del producto:</label>
						<input type="text" class="form-control" name="descripcionProd" id="descripcionProd">
					</div>

					<div class="form-group">
						<label for="precioProd">Precio del producto:</label>
						<input type="text" class="form-control" name="precioProd" id="precioProd">
					</div>

					<div class="form-group">
						<label for="unidadesProd">Unidades del producto:</label>
						<input type="text" class="form-control" name="unidadesProd" id="unidadesProd">
					</div>

					<div class="form-group">
						<label for="fechaAlta">Fecha de alta:</label>
						<input type="date" class="form-control" name="fechaAlta" id="fechaAlta" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
					</div>

					<div class="form-group">
						<label for="activado">Producto activado:</label>
						<input type="checkbox" class="form-control" name="activado" id="activado" checked>
					</div>
					
					<div class="form-group" id="imagenes">
						<label for="imagenes">
							Imagenes: 
							<a href="#">Agregar otra</a>
						</label>
						<input type="file" name="imagenes[]">
					</div>

					<input type="submit" class="form-control" name="enviar" value="enviar">

				</form>
				<?php
			}
		}else{
			echo 'No tienes permisos para estar aqui. Logueate....!!';
		} //fin del else de if($_SESSION['conectado'])
		break;


	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////////  FILTRADO   /////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'filtrado':
		?>
		<hr>
		<table class="table table-striped table-hover">
		<tr><th>Nombre del producto</th></tr>
		<?php
		$fechasql=$_GET['fechasql'];
		$sql="SELECT * FROM productos WHERE fechaAlta='$fechasql'";
		$consulta=$conexion->query($sql);
		while($registro=$consulta->fetch_array()){
			?>
			<tr><td><?php echo $registro['nombreProd'] ?></td></tr>
			<?php
		}
		?>
		</table>
		<?php	
		break;	


	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////////  FILTRADO2   /////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'filtrado2':

	$fechasql=$_GET['fechasql'];
	?>
	<h4>
		Productos filtrados a fecha
		 - 
		<small>
			<?php echo dimeFecha($fechasql); ?>	
		</small>
	</h4>
	<?php

	if($_SESSION['conectado']){
	?>
	<h4>
		<a href="index.php?p=productos.php&accion=insertar">
			Insertar
		</a>
	</h4>
	<?php } ?>
	<hr>
	<table class="table table-striped table-hover">
	<tr>
		<th>Nombre del producto</th>
		<th>Acciones del producto</th>
	</tr>
	<?php 
	//Hacemos un listado con paginacion
	//Lo primero es saber el numero TOTAL		 
	$sql="SELECT * FROM productos WHERE fechaAlta='$fechasql'";
	$consulta=$conexion->query($sql);
	$numeroTotalDeRegistros=$consulta->num_rows;

	//Establezco cuantos registros quiero por pagina
	$numeroDeRegistrosPorPagina=5; //a mano

	/////////////////////////////////////////////////////
	//////AQUI ESTABA ANTES LO DE $_GET['numeroDePagina']
	/////////////////////////////////////////////////////

	//Me las apaño para hacer la consulta segun el 
	// $numeroDePagina que le paso
	$inicioLimite=$numeroDePagina*$numeroDeRegistrosPorPagina;

	$sql="SELECT * FROM productos WHERE fechaAlta='$fechasql' LIMIT $inicioLimite,$numeroDeRegistrosPorPagina";

	//Ejecuto la consulta, esta vez con su LIMIT (paginado)
	$consulta=$conexion->query($sql);

	//Hacemos el bucle para recorrer los resultados
	while($registro=$consulta->fetch_array()){
		?>
		<tr>
			<td>
				<?php echo $registro['nombreProd'] ?>
			</td>
			<td>
				<a href="index.php?p=productos.php&accion=ver&id=<?php echo $registro['idProd']; ?>">Ver</a>
				<?php 
				if($_SESSION['conectado']){
				?>
				 - 
				<a href="index.php?p=productos.php&accion=borrar&id=<?php echo $registro['idProd']; ?>&numeroDePagina=<?php echo $numeroDePagina; ?>" onClick="if(!confirm('Estas seguro?')){return false;};">Borrar</a>
				 - 
				<a href="index.php?p=productos.php&accion=modificar&id=<?php echo $registro['idProd']; ?>&numeroDePagina=<?php echo $numeroDePagina; ?>">Modificar</a>
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
			<li><a href="index.php?p=productos.php&accion=filtrado2&numeroDePagina=<?php echo ($numeroDePagina-1); ?>&fechasql=<?php echo $fechasql ?>">&laquo;</a></li>
		<?php } ?>
		
		<?php  
		//Calculo el numero total de paginas
		$numeroTotalDePaginas=ceil($numeroTotalDeRegistros/$numeroDeRegistrosPorPagina);
		
		//Uso un bucle para dibujar los numericos
		for($numPagina=0;$numPagina<$numeroTotalDePaginas;$numPagina++){

			if($numeroDePagina==$numPagina){
				$activa='active';
			}else{
				$activa='';
			}

		?>

		<li class="<?php echo $activa; ?>">
			<a href="index.php?p=productos.php&accion=filtrado2&numeroDePagina=<?php echo $numPagina; ?>&fechasql=<?php echo $fechasql ?>">
				<?php echo ($numPagina+1); ?>	
			</a>
		</li>
		
		<?php  
		} //Fin del bucle for
		?>


		<?php if($numeroDePagina==($numeroTotalDePaginas-1)){ ?>
			<li class="disabled"><a href="#">&raquo;</a></li>
		<?php }else{ ?>
			<li><a href="index.php?p=productos.php&accion=filtrado2&numeroDePagina=<?php echo ($numeroDePagina+1); ?>&fechasql=<?php echo $fechasql ?>">&raquo;</a></li>
		<?php } ?>


	</ul>
	</div>

	<?php

	break;

	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	//////////////////  BUSCADOR   /////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	////////////////////////////////////////////////////
	case 'buscador':

		//Recojo la palabra de busqueda
		$palabra=$_GET['palabra'];

		//Establezco la consulta en mi Base de datos
		$sql="SELECT * FROM productos WHERE nombreProd LIKE '%$palabra%' OR descripcionProd LIKE '%$palabra%'";

		//Ejecuto la consulta
		$consulta=$conexion->query($sql);

		?>
		<table class="table table-striped buscador">
			<tr>
				<td>Nombre del producto</td>
				<td>Descripcion producto</td>
			</tr>
			<?php  
			while($registro=$consulta->fetch_array()){
				?>
				<tr>
					
					<td><?php echo str_ireplace($palabra, '<span class="label label-info"><strong><u>'.$palabra.'</u></strong></span>', $registro['nombreProd']); ?></td>
					<td><?php echo str_ireplace($palabra, '<span class="label label-info"><strong><u>'.$palabra.'</u></strong></span>', $registro['descripcionProd']); ?></td>

				</tr>
				<?php
			}
			?>
		</table>
		<?php
		break;

} //Fin del switch($accion)
?>