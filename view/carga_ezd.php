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
?>
	<option value="<?php echo $_provincia["desc_EZD"]?>"><?php echo $_provincia["desc_EZD"]?></option>
<?php endforeach;?>


