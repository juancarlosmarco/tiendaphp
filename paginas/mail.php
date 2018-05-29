


<?php  

//para el envío en formato HTML
$cabeceras = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-type: text/html; charset=utf-8\r\n";

//dirección del remitente
$cabeceras .= "From: M.Rajoy <mrajoy@pp.es>\r\n";

//dirección de respuesta, si queremos que sea distinta que la del remitente
//$cabeceras .= "Reply-To: mariano@pp.es\r\n";

//direcciones que recibián copia
//$cabeceras .= "Cc: davidfraj@gmail.com\r\n";

//direcciones que recibirán copia oculta
//$cabeceras .= "Bcc: davidfraj@hotmail.com,dfraj@systemzaragoza.com\r\n";



$destino='davidfraj@gmail.com';
$asunto='Correo desde System 25/05/2018';
$cuerpo='<img src="https://i2.wp.com/eneagra1-cp178.wordpresstemporal.com/wp-content/uploads/2013/06/mariano-rajoy-brey.jpg?resize=300%2C300"><br> Estimado amigo..... <br>enviado desde PHP';

if(mail($destino, $asunto, $cuerpo, $cabeceras)){
	echo 'Email enviado';
}else{
	echo 'Tenemos un problema, escribenos a admin@gmail.com';
}


?>