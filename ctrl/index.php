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
		//ACA HAY QUE VALIDAR QUE TIPO DE SESSION TIENE, SI USER O USER_GT
		if(@$_SESSION["user"]):
			$usuario_tipo ="KA";
			$_usuario = unserialize($_SESSION["user"]);
		elseif(@$_SESSION["user_gt"]):
			$usuario_tipo ="GT";
			$_usuario = unserialize($_SESSION["user_gt"]);
		endif;	

			if($usuario_tipo == "KA"):
				if($_usuario->active == 0):
					$tipo = "KA";
					include("../view/cambio_clave.php");
					break;
				endif;	

				if($_usuario->acepta_bases == 0):
					if($_usuario->mecanica == "A"):
						include("../view/acepta-bases-condiciones-A.php");
					else:
						include("../view/acepta-bases-condiciones-B.php");			
					endif;	

				endif;	
				$site="home";	
				Template::draw_header($site);
				if($_usuario->mecanica == "A"):
					include("../view/home-5.php");
				elseif($_usuario->mecanica == "B"):
					include("../view/home.php");

				endif;		

				Template::draw_footer($site);

			elseif($usuario_tipo == "GT"):
				if($_usuario->active == 0):
					$provincias = User_gt::get_provincias_user($_usuario->usuario);
					include("../view/provincia_ezd.php");
					break;
				endif;					
				if($_usuario->acepta_bases == 0):

						include("../view/acepta-bases-condiciones-gt.php");
					break;

				endif;	


				Template::draw_header_gt($site, $_usuario);
				include("../view/home_gt.php");
				Template::draw_footer_gt($site);
				//print_r($_usuario);

			endif;	

/*
		Template::draw_header();
		include("../view/index.php");
		Template::draw_footer();*/
		break;

		}
	case 'cambiar_clave':
		{
		if($_POST["tipo"] == "KA" ):	

			$_usuario = unserialize($_SESSION["user"]);

			$change = User::change_pass($_usuario->id, "Mlbka123", $_POST["clave_nueva"]);
			
			session_destroy();
			session_start();

		 	$_usuario_new = new User($_usuario->id);
		  	$_SESSION["user"] = serialize($_usuario_new);

			if($change):
				include("../view/completar_datos.php");

			endif;	
		elseif($_POST["tipo"] == "GT" ):

			$_usuario = unserialize($_SESSION["user_gt"]);

			$change = User_gt::change_pass($_usuario->id, "Mlbka123", $_POST["clave_nueva"]);
			
			session_destroy();
			session_start();

		 	$_usuario_new = new User_gt($_usuario->id);
		  	$_SESSION["user_gt"] = serialize($_usuario_new);

			if($change):
				include("../view/completar_datos_gt.php");

			endif;		

		endif;	


		break;
		}	
	case 'cambiar_datos':
		{
		$_usuario = unserialize($_SESSION["user"]);

		User::actualizar_datos($_usuario->id, $_POST);

		session_destroy();
		session_start();

	 	$_usuario_new = new User($_usuario->id);
	  	$_SESSION["user"] = serialize($_usuario_new);		
		$_usuario = unserialize($_SESSION["user"]);

		if($_usuario->mecanica == "A"):
			if($_usuario->acepta_bases == 0):
				include("../view/acepta-bases-condiciones-A.php");
			else:
			
			endif;	

		elseif($_usuario->mecanica == "B"):
			if($_usuario->acepta_bases == 0):
				include("../view/acepta-bases-condiciones-B.php");
			else:
			
			endif;	

		endif;	

		break;	
		}

	case 'cambiar_datos_gt':
		{
		$_usuario = unserialize($_SESSION["user_gt"]);


			User_gt::carga_datos($_usuario->id, $_POST);


		if(isset($_POST["mas"])):
			include("../view/completar_datos_gt.php");

		elseif(isset($_POST["guardar"])):	

		  	User_gt::sumar_puntos($_usuario->id, 10);

			session_destroy();
			session_start();

		 	$_usuario_new = new User_gt($_usuario->id);
		  	$_SESSION["user_gt"] = serialize($_usuario_new);
			$_usuario = unserialize($_SESSION["user_gt"]);


			include("../view/home_gt_popin.php");

		endif;	
			break;	
		}

	case 'acepta_bases':
		{
		$_usuario = unserialize($_SESSION["user"]);			
		User::acepta_basesycondiciones($_usuario->id);		

		session_destroy();
		session_start();

	 	$_usuario_new = new User($_usuario->id);
	  	$_SESSION["user"] = serialize($_usuario_new);		
		$_usuario = unserialize($_SESSION["user"]);

	      echo '<script type="text/javascript">

	      window.location.assign("video.html");
	      </script>';               
	      header('Location:' . HOME . 'video.html');		

		break;	
		}

	case 'acepta_bases_gt':
		{
			
		$_usuario = unserialize($_SESSION["user_gt"]);			
		User_gt::acepta_basesycondiciones($_usuario->id);		

		session_destroy();
		session_start();

	 	$_usuario_new = new User($_usuario->id);
	  	$_SESSION["user_gt"] = serialize($_usuario_new);		
		$_usuario = unserialize($_SESSION["user_gt"]);

	      echo '<script type="text/javascript">

	      window.location.assign("home.html");
	      </script>';               
	      header('Location:' . HOME . 'home.html' );		

		break;	
		}

	case 'volumen_compra':
		{
		$site="volumen_compra";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
			$link_volumen =  IMGS . "superen-volumen-compraMecanicaA.png";
		else:
			$link_volumen =  IMGS . "ka/superen-volumen.png";
		endif;	

		Template::draw_header($site);
		include("../view/volumen_compra.php");
		Template::draw_footer($site);			

		}
		break;	

	case 'stock':
		{
		$site="stock";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
			$link_stock =  IMGS . "aseguren-stockmecanicaA.png";
		else:
			$link_stock =  IMGS . "ka/aseguren-stock.png";
		endif;	

		Template::draw_header($site);
		include("../view/stock.php");
		Template::draw_footer($site);			

		}
		break;	
	case 'exhiban':
		{
		$site="exhiban";				
		$_usuario = unserialize($_SESSION["user"]);
		Template::draw_header($site);
		include("../view/exhiban.php");
		Template::draw_footer($site);			

		}
		break;	

	case 'web':
		{
		$site="web";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
			$link_web =  IMGS . "dirijan-webmecanicaA.png";
		else:
			$link_web =  IMGS . "ka/dirijan-web.png";
		endif;
		Template::draw_header($site);
		include("../view/web.php");
		Template::draw_footer($site);			

		}
		break;	
	case 'volumen_venta':
		{
		$site="volumen_venta";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
		Template::draw_header($site);
		include("../view/volumen_venta.php");
		Template::draw_footer($site);			
		else:
			redireccionar();
		endif;	
		}
		break;	

	case 'premios':
		{
		$site="premios";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
		Template::draw_header($site);
		include("../view/premios.php");

		else:
			redireccionar();
		endif;	
		}
		break;	

	case 'premiosb':
		{ 
		$site="premiosb";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "B"):

		Template::draw_header($site);
		include("../view/premiosb.php");
	
		else:
			redireccionar();
		endif;	
		}
		break;	

	case 'basesycondiciones':
		{
		$site="basesycondiciones";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
		Template::draw_header($site);
		include("../view/bases-condiciones-A.php");
		Template::draw_footer($site);			

		else:
			redireccionar();
		endif;	
		}
		break;	

	case 'basesycondicionesb':
		{
		$site="basesycondicionesB";				
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "B"):
		Template::draw_header($site);
		include("../view/bases-condiciones-B.php");
		Template::draw_footer($site);			
		else:
			redireccionar();
		endif;	
		}
		break;	
	case 'video':
		{
		$site= "video";
		$_usuario = unserialize($_SESSION["user"]);
		if($_usuario->mecanica == "A"):
			$link_video = "SIOW-A.mp4";

		elseif($_usuario->mecanica == "B"):
			$link_video = "SIHW-B.mp4";
		

		endif;	

		Template::draw_header($site);
		include("../view/video.php");
		Template::draw_footer($site);			

		break;	
		}

	case 'video_gt':
		{
		$site= "video";

			$link_video = "video_gt.mp4";
		Template::draw_header_gt($site);
		include("../view/video.php");
		Template::draw_footer_gt($site);			

		break;	
		}		
	case 'ranking':
		{
		$site="ranking";				
		$_usuario = unserialize($_SESSION["user"]);

		Template::draw_header($site);
		include("../view/ranking.php");

		}
		break;	

	case 'ranking-locales':
		{
		$site="ranking-locales";				
		$_usuario = unserialize($_SESSION["user"]);
		Template::draw_header($site);
		if($_usuario->mecanica == "A"):
			$pdvs= User::get_pdvs_a($_usuario->usuario);	
			include("../view/ranking-locales-a.php");
		elseif($_usuario->mecanica == "B"):
			$pdvs= User::get_pdvs_b($_usuario->usuario);	
			include("../view/ranking-locales-b.php");
		endif;	

		Template::draw_footer($site);			

		}
		break;	
/*// GT*///
	case 'confirma_gt_datos':
		{
		$site="confirma_datos";
//		print_r($_POST);die;
		$_usuario = unserialize($_SESSION["user_gt"]);
		$datos = User_gt::confirma_datos($_usuario->usuario, $_POST);

		include("../view/confirma_datos.php");

		}

		break;

	case 'usuario_confirmado':
		{
		$site="confirma_datos";
//		print_r($_POST);die;

	//  	User_gt::activar_usuario($_POST["user_id"]);

		session_destroy();
		session_start();

	 	$_usuario_new = new User_gt($_POST["user_id"]);
	  	$_SESSION["user_gt"] = serialize($_usuario_new);

	  	$tipo = "GT"; 
		include("../view/cambio_clave.php");



		}

		break;	
	case 'mrl_core':
		{	$site="core";
			$_usuario = unserialize($_SESSION["user_gt"]);
			if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"):
				$img_muestra ="mlb-core-PUNTOS.png";
			else:
				$img_muestra ="mlb-core.png";
			endif;	
//			Template::draw_header_gt($site);
			include("../view/mrl_core.php");
//			Template::draw_footer_gt($site);



		}
			# code...
			break;	

	case 'mlb_compra':
		{	$site="core";
//			Template::draw_header_gt($site);
			$_usuario = unserialize($_SESSION["user_gt"]);
			if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"):
				$img_muestra ="compra-mlb-PUNTOS.png";
			else:
				$img_muestra ="compra-mlb.png";
			endif;	

			include("../view/mlb_compra.php");
//			Template::draw_footer_gt($site);



		}
			# code...
			break;	
	case 'premios_GT':
		{	$site="core";
			$_usuario = unserialize($_SESSION["user_gt"]);
			//print_r($_usuario);die;
//			Template::draw_header_gt($site);
			include("../view/premios_GT.php");
//			Template::draw_footer_gt($site);



		}
			# code...
			break;	

endswitch;
?>
