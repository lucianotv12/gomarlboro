<?php
session_start();

include_once("../funciones.php");
//include_once("../../models/clientes.class.php");

//validar_permanencia();
//conectar_bd();
validar_permanencia();
//validar_permanencia_admin();
//$_usuario = unserialize($_SESSION["usuario"]);

#$template = new Template();

if(!isset($_GET["accion"]))$accion= "home";
else $accion = $_GET["accion"];
$detalle = false;

$site="";	
switch($accion):
	case "home" :
		{				
		$site="home";	


		$_usuario = unserialize($_SESSION["user"]);

		if($_usuario->active == 0):
			include("../view/cambio_clave.php");
			break;
		endif;	

		Template::draw_header();
		include("../view/index.php");
		Template::draw_footer();
		break;

		}
	case 'cambiar_clave':
		echo "echo horhaorho";

		break;	

endswitch;
?>
