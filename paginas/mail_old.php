<?php 
$destino='juancarlosmarco@gmail.com';
$asunto='Correo desde System';
$cuerpo='Correo desde PHP';

if(mail($destino,$asunto,$cuerpo)){
	echo'Email enviado';
}else{
	echo 'Tenemos un problema, escribenos a admin@gmail.com';
}



 ?>