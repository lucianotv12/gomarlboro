<?php

session_start();

include_once("../funciones.php");


/*validar_permanencia();
conectar_bd();
*/
$_usuario = unserialize($_SESSION["user_gt"]);
	

//$_GET["code"];
$idProvincia = $_GET["code"];

$_provincias=User_gt::get_ezd($idProvincia,$_usuario->usuario);	

foreach($_provincias as $_provincia):
	if($_provincia["desc_EZD"] == 'CASA MUNIZ S.A.'):
		$muestra = 'CASA MU&Ntilde;IZ S.A.';
	else:
		$muestra = $_provincia["desc_EZD"];

	endif;	
?>
	<option value="<?php echo utf8_encode($_provincia["desc_EZD"])?>"><?php echo $muestra?></option>
<?php endforeach;?>


