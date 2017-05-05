<?php
define('ROOT','localhost');
define('DATABASE','rec');
define('USER','root');
define('PASS','');
define('HOME','http://localhost/rec/');
define('ADMIN','http://localhost/rec/');
define('IMGS','http://localhost/rec/template/img/');
define('IMGS_PUB','http://localhost/rec/template/img/publicaciones/usuarios/');
define('IMGS_PERFIL','http://localhost/rec/template/img/usuarios/perfiles/');
define('IMGS_PORTADA','http://localhost/rec/template/img/usuarios/portadas/');
define('JS','http://localhost/rec/template/js/');
define('CSS','http://localhost/rec/template/css/');
define('VIEW','http://localhost/rec/view/');
define('CTRL','http://localhost/rec/ctrl/');
define('CLASES','http://localhost/rec/models/');
define('BOOTSTRAP_CSS','http://localhost/rec/template/css/bootstrap/');
define('BOOTSTRAP_JS','http://localhost/rec//template/js/bootstrap/');
define('VALIDACIONES','http://localhost/rec/template/js/validaciones/');


/*function conectar_bd()
	{
		try{
			$conn = new PDO("mysql:host=".ROOT.";dbname=".DATABASE, USER, PASS);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		
		}catch(PDOException $e){
			echo "ERROR: " . $e->getMessage();
		}
	}*/


/*----------------------------------------------------------------------------*/
/* funcion que hace una inclusion automatica de las clases
/*----------------------------------------------------------------------------*/
function __autoload($class_name)
	{
	$bajadas = "";
	while (!is_dir($bajadas."models"))
		{
		$bajadas .= "../";
		}

		require_once($bajadas."models/".strtolower($class_name).".class.php");
	}


function validar_permanencia ($_redireccion_estricta = true)
	{
	if (!isset($_SESSION["user"]))
		{
		# Verifico si me pasa una URL para mostrar un mensaje de error
		if($_redireccion_estricta)
			{# sino muestro el mensaje por defecto y redirecciono al Index
			redireccionar("Su sessi&oacute;n ha caducado, aguarde, ser&aacute; redireccionado...",3);
			}
		return false;
		}
	else
		{
		return true;
		}
	}
function redireccionar (  $message="", $seconds=0)
	{
	$url= HOME ;
//	header("Refresh: ".$seconds."; url=".$url); // waits 3 seconds & sends to homepage
    echo '<script type="text/javascript">window.location.assign("'. HOME .'");</script>';

	echo "<h4>".$message."</h4>";
	die();
	}
	

?>
