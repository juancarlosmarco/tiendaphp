<?php  


//fichero includes/funciones.php
//En este fichero, escribire, funciones varias
//para mi web

//Declaro VARIABLES que sirvan para TODO (Variables GLOBALES)
$meses=['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$dias=['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];


//Funcion para devolver una fecha formateada al estilo
// Lunes, 15 de mayo de 2018
function dimeFecha($lafecha){

	global $meses, $dias;
	$fecha = new DateTime($lafecha);
	return $dias[$fecha->format('w')].', '.$fecha->format('d').' de '.$meses[$fecha->format('n')].' de '.$fecha->format('Y');

} //fin de la funcion dimeFecha()


//Funcion para devolver una fecha formateada al estilo
// 15-mayo-2018
function dimeFechaCorta($lafecha){

	global $meses;
	$fecha = new DateTime($lafecha);
	return $fecha->format('d').'-'.$meses[$fecha->format('n')].'-'.$fecha->format('Y');

} //fin de la funcion dimeFechaCorta()


//Funcion para devolver una TABLA en HTML, con el mes que
// le pase del año actual
function dimeMes($mes, $anyo){

	global $meses;
	global $conexion;

	$r='';
	$r.='<table class="table table-striped">';
	$r.='<tr>';
	$r.='<th colspan="7">'.ucfirst($meses[$mes]).' - '.$anyo.'</th>';
	$r.='</tr>';
	$r.='<tr>';
	$r.='<th class="text-center">L</th>';
	$r.='<th class="text-center">M</th>';
	$r.='<th class="text-center">X</th>';
	$r.='<th class="text-center">J</th>';
	$r.='<th class="text-center">V</th>';
	$r.='<th class="text-center">S</th>';
	$r.='<th class="text-center">D</th>';
	$r.='</tr>';

	//Creo la fecha TIMESTAMP del dia 1 del mes y año dado
	$f=mktime(0,0,0,$mes, 1, $anyo);
	$diaSemana=date('N',$f); //1 lunes a 7 domingo	
	if($diaSemana>1){
		$r.='<tr>';
		for($i=1;$i<$diaSemana;$i++){
			$r.='<td></td>';
		}
	}

	//Voy a crearme variables necesarias
	$fechahoy=mktime(0,0,0,date('n'), date('j'), date('Y'));

	$ultimoDiaDelMes=date('t',$f);
	for($dia=1;$dia<=$ultimoDiaDelMes;$dia++){
		//Creo la fecha TIMESTAMP de ese DIA
		$fecha=mktime(0,0,0,$mes,$dia,$anyo);
		//Si es lunes, abro tr
		if(date('w',$fecha)==1){
			$r.='<tr>';
		}

		//Establezco la clase CSS que va a tener dicho dia
		$clasedia='text-center';

		//Si el dia es el de hoy, le agrego una clase
		if($fechahoy==$fecha){
			$clasedia.=' info'; //Agrego esta clase, 
		}

		//Si ese dia, tiene productos..... le pongo otra clase
		//Necesito hacer una consulta a la bbdd
		//$sql="SELECT * FROM productos WHERE fechaAlta='".date('Y-m-d', $fecha)."'";

		$fechasql=date('Y-m-d', $fecha);
		$sql="SELECT * FROM productos WHERE fechaAlta='$fechasql'";

		//Ejecuto la consulta
		$consulta=$conexion->query($sql);

		//Me creo una variable, con el contenido del dia
		$eldia=$dia;

		//Si hay registros, aplico classes, y agrego enlaces
		if($consulta->num_rows>0){
			$eldia='<a href="index.php?p=productos.php&accion=filtrado2&fechasql='.$fechasql.'" class="label label-success">'.$dia.'</a>';
		}

		//Dibujo el dia
		$r.='<td class="'.$clasedia.'">'.$eldia.'</td>';

		//Si es domingo, cierro tr
		if(date('w',$fecha)==0){
			$r.='</tr>';
		}
	} //Fin del bucle for (PRINCIPAL)

	$r.='</table>';
	return $r;
}
?>