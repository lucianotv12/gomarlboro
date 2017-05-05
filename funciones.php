<?php
$url = "http://localhost/gomarlboro/";
define('ROOT','localhost');
define('DATABASE','gomarlboro');
define('USER','root');
define('PASS','1610lucho');
define('HOME',$url);
define('ADMIN',$url);
define('IMGS',$url . 'img/');
define('JS', $url. 'template/js/');
define('CSS', $url . 'template/css/');
define('VIEW',$url . 'view/');
define('CTRL', $url . 'ctrl/');
define('CLASES', $url . 'models/');


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
