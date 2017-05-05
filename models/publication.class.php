<?php
class Publication { 
	var $id; 
	var $description; 
	var $image_url; 
	var $active; 
	var $date; 
	var $userId; 


	function Publication($_id=0) { 
		if ($_id<>0) { 
			$conn = new Conexion();

			$sql = $conn->prepare('select * from rewards where id= :ID');
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);

			$this->id = $datos_carga['id']; 
			$this->description = $datos_carga['description']; 
			$this->image_url = $datos_carga['image_url']; 
			$this->active = $datos_carga['active']; 
			$this->date = $datos_carga['date']; 
			$this->userId = $datos_carga['userId'];

		} 
	} 

	function save() {//Guarda o inserta segun corresponda 

		$conn = new Conexion();
//		date_default_timezone_set('America/Argentina/Buenos_Aires');


		if ($this->id<>0) {
			$sql = $conn->prepare("update publications set description = '$this->description', image_url = '$this->image_url', active = '$this->active', date = '$this->date', userId = '$this->userId' where id='$this->id'");
 			$sql->execute();
			$lastId = "";
		} else { 
			$sql = $conn->prepare( "insert into publications values (null, '$this->description', '$this->image_url', '$this->active', '$this->date', '$this->userId')"); 
 			$sql->execute();
			$lastId = $conn->lastInsertId();

		} 
		$conn = null;
		$sql = null;
		return $lastId;		
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	function obtenerUserArroba($contenido,$inicio,$fin,$insertId){
	   $r = explode($inicio, $contenido);
//	   print_r($r);die;
	   foreach($r as $arroba):
	   		if(isset($arroba) and $arroba != reset($r)):
		        $j = explode($fin, $arroba);
		    	//OBTENGO EL id USER
//		   		print_r($r[0]);die;
		    	$user_id = User::get_user_by_name($j[0]);	
		    	$user_id = $user_id["id"];			    	
				Publication::new_publications_mentions($insertId, $user_id);	    	
				Notification::new_notification("@", $insertId, $user_id);		
		    	
	//	   	print_r($j[0]); // RECONOCE CADA PERSONA ARROBADA. 

	   		endif;	
	   endforeach;

	}

	function obtenerEnlaceArroba($nombre){
	/*	print_r($nombre);die;
		$nombre = substr($nombre, 1);*/
	return	$nombre;
	//	return $nombrex;
	}
	 
	function new_publications_mentions($insertId, $user_id){
		//	echo  $insertId . " ::  " . $user_id;die; 
			$conn = new Conexion();		
			$sql = $conn->prepare( "insert into publications_mentions values (:PUBLICATION, :USER)"); 
 			$sql->execute(array('PUBLICATION' => $insertId, 'USER' => $user_id));
 			$conn = null;
 			$sql = null;


	}

	 
	//echo obtenerCadena($mitexto,'fama','victoria');


	function new_publication($_PARAM, $_user_id, $_archivo=0){

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$cadena_origen= $_PARAM["comentar_desc"];


		 
		$cadena_resultante= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1" target=\"_blank\">$0</a>', $cadena_origen);
		$cadena_resultante= preg_replace("/href=\"www/", 'href="http://www', $cadena_resultante);
		$cadena_resultante = preg_replace("/(@[^.]+)/", '<a   href="' .HOME . 'buscador/$1/">$0</a>', $cadena_resultante);
		$cadena_resultante = preg_replace("/(#[^.]+)/", '<a target=\"_blank\"  href="http://twitter.com/search?q=$1">$0</a>', $cadena_resultante);

		$publication = new Publication();

		$publication->set_description(Reward::test_input($cadena_resultante));
		$publication->set_image_url(Reward::test_input(""));
		$publication->set_userId(Reward::test_input($_user_id));
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;
		$publication->set_date($hora_actual);
		$publication->set_active(1);

		$insertId = $publication->save();

		//MENSIONES  : AGREGA NOTIFICACIONES Y RELACIONA USERS MENCIONADOS CON PUBLICACIONES
		if($insertId):
			Publication::obtenerUserArroba($cadena_origen, '@', '.', $insertId);
		endif;

		if($_archivo):  
			$name_img = Publication::upload_file($_archivo, $insertId );
			$conn = new Conexion;
			$sql = $conn->prepare("update publications set  image_url = '$name_img' where id='$insertId'");
 			$sql->execute();


		endif;			


		//AGREGO REGISTRO EN MURO
		$publication->new_wall_p($insertId, $_user_id);
//		

		//AGREGO REGISTRO EN MURO



	}

	function upload_file($_archivo, $insertId){

		if ($_archivo["imagen"]["error"] > 0){
	//		echo "ha ocurrido un error";
		} else { 
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamano del archivo no exceda los 100kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png", "video/mp4" );
			$limite_kb = 100000;

			if (in_array($_archivo['imagen']['type'], $permitidos) && $_archivo['imagen']['size'] <= $limite_kb * 1024 ){ 
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				//imagen : cambio el nombre de la imagen
				$ext = pathinfo($_archivo['imagen']['name'], PATHINFO_EXTENSION);				
				$name_img = $insertId . "." . $ext;

				$ruta = "../template/img/publicaciones/usuarios/" . $name_img;

				//comprovamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta)){ 
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false

					$resultado = @move_uploaded_file($_archivo["imagen"]["tmp_name"], $ruta);

					$ruta_imagen = $ruta;

					$miniatura_ancho_maximo = 550;
					$miniatura_alto_maximo = 1000;

					$info_imagen = getimagesize($ruta_imagen);
					$imagen_ancho = $info_imagen[0];
					$imagen_alto = $info_imagen[1];
					$imagen_tipo = $info_imagen['mime'];


					$proporcion_imagen = $imagen_ancho / $imagen_alto;
					$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

					if ( $proporcion_imagen > $proporcion_miniatura ){
						$miniatura_ancho = $miniatura_ancho_maximo;
						$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
					} else if ( $proporcion_imagen < $proporcion_miniatura ){
						$miniatura_ancho = $miniatura_ancho_maximo * $proporcion_imagen;
						$miniatura_alto = $miniatura_alto_maximo;
					} else {
						$miniatura_ancho = $miniatura_ancho_maximo;
						$miniatura_alto = $miniatura_alto_maximo;
					}


					switch ( $imagen_tipo ){
						case "image/jpg":
						case "image/jpeg":
							$imagen = imagecreatefromjpeg( $ruta_imagen );
							break;
						case "image/png":
							$imagen = imagecreatefrompng( $ruta_imagen );
							break;
						case "image/gif":
							$imagen = imagecreatefromgif( $ruta_imagen );
							break;
					}

					$lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

					imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);

					unlink($ruta);

					imagejpeg($lienzo, $ruta, 91);				
					if ($resultado){
						return ($name_img) ;
	//					echo "el archivo ha sido movido exitosamente";
					} else {
	//					echo "ocurrio un error al mover el archivo.";
					}
				} else {
	//				echo $_archivo['imagen']['name'] . ", este archivo existe";
				}
			} else {
				echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
		}


	}


	function new_wall_p($insertId, $_user_id){
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;
		// nuevo registro en muro
		$insertId = Reward::test_input($insertId);		
		$conn = new Conexion();

		$sql = $conn->prepare("insert into wall (id, type, typeId, date, active, userId) values (null, 'P', '$insertId', '$hora_actual', '$this->active', '$_user_id')");
		$sql->execute();



	}


	function get_publication_id($_id){

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT P.*, U.name as usuario, U.img_perfil FROM publications P INNER JOIN users as U on P.userId = U.id WHERE P.id = :ID' );
		$sql->execute(array('ID' => $_id));

		return $resultado = $sql->fetch(PDO::FETCH_ASSOC);


		$conn = null;
		$sql = null;


	}


	function get_publications($_userid){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT P.*, U.name as usuario, W.id as wall_id FROM wall W inner join publications P On P.id = W.typeId AND W.type = 'P' INNER JOIN users as U on P.userId = U.id WHERE P.userId = :ID" );
		$sql->execute(array('ID' => $_userid));

		return $resultado = $sql->fetchAll();


		$conn = null;
		$sql = null;


	}

	function get_publicaciones(){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT P.*, U.name as usuario, W.id as wall_id FROM wall W inner join publications P On P.id = W.typeId AND W.type = 'P' INNER JOIN users as U on P.userId = U.id" );
		$sql->execute();

		return $resultado = $sql->fetchAll();


		$conn = null;
		$sql = null;


	}	

	function get_publications_function(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) as cantidad, U.function FROM publications P INNER JOIN users U on P.userId = U.id where P.active = 1 GROUP by function' );
		$sql->execute();
		return $sql->fetchAll();

		$conn = null;
		$sql = null;		
		
	}

	function get_publications_subarea(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) as cantidad, U.subarea FROM publications P INNER JOIN users U on P.userId = U.id where P.active = 1 GROUP by subarea' );
		$sql->execute();
		return $sql->fetchAll();

		$conn = null;
		$sql = null;		
		
	}

	function get_total_megusta(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT COUNT(*) AS cantidad FROM wall W INNER JOIN wall_likes WL ON W.id = WL.idWall where W.active = 1 and W.type = "p"' );
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);

		$conn = null;
		$sql = null;


	}

	function get_total_publications(){ 
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT COUNT(*) AS cantidad FROM publications where active = 1' );
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);

		$conn = null;
		$sql = null;

	}

	/*---GETTERS--------------------------------------------------------------*/ 
	function get_id() { return($this->id); }
	function get_description() { return($this->description); } 
	function get_image_url() { return($this->image_url); } 
	function get_active() { return($this->active); } 
	function get_date() { return($this->date); } 
	function get_userId() { return($this->userId); }

	/*------------------------------------------------------------------------*/ 
	
	/*---SETTERS--------------------------------------------------------------*/ 
	function set_id($_id) { $this->id = $_id; } 
	function set_description($_description) { $this->description = $_description; } 
	function set_image_url($_image_url) { $this->image_url = $_image_url; } 
	function set_active($_active) { $this->active = $_active; } 
	function set_date($_date) { $this->date = $_date; } 
	function set_userId($_userId) { $this->userId = $_userId; } 

	/*------------------------------------------------------------------------*/ 

}


?>