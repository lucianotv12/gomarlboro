<?php
class Wall {
	 
	 var $id; 
 	 var $type;
 	 var $typeId; 
 	 var $date; 
 	 var $active; 


 	 function Wall($_id=0) { 
 	 	if ($_id<>0) { 
			$conn = new Conexion();

			$sql = $conn->prepare("select * from wall where id=:ID"); 
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);
 			$this->id = $datos_carga['id']; 
 			$this->type = $datos_carga['type']; 
 			$this->typeId = $datos_carga['typeId']; 
 			$this->date = $datos_carga['date']; 
 			$this->active = $datos_carga['active']; 
 	 		} 
 	 } 

 	 function save() {//Guarda o inserta segun corresponda 
 	 	if ($this->id<>0) { 
 	 		$query_save = "update wall set type = $this->type, typeId = $this->typeId, date = $this->date, active = $this->active where id=$this->id"; 
 	 		mysql_query($query_save) or die(mysql_error()); 
 	 	} else { 
 	 		$query_save = "insert into wall values (null, $this->type, $this->typeId, $this->date, $this->active)"; 
 	 		mysql_query($query_save) or die(mysql_error()); 
 	 		$this->id = mysql_insert_id(); 
 	 	} 
 	 }


 	 function get_walls($_id=0){

 	 	if($_id):
 	 		$whereclause = " AND id = :ID ";
 	 		$var_execute = array('ID' => $_id);

 	 	else:

	 	 		$whereclause = ""; 	 		
		 	 	$var_execute=null;

 	 	endif;	


		$conn = new Conexion();

		$sql = $conn->prepare("SELECT * FROM wall WHERE active = 1 $whereclause and typeId != 0 order by id DESC limit 100" );
		$sql->execute($var_execute);

		return ($sql->fetchAll()); 	 	
		$conn = null;
		$sql = null;

 	 }

 	 function get_wall_by_user($userId){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT W.* FROM wall W LEFT JOIN rewards R on W.typeId = R.id and W.type = 'R' LEFT JOIN publications P ON W.typeId = P.id and W.type = 'P'LEFT JOIN publications_mentions PM ON P.id = PM.idPublication WHERE W.active = 1 AND ( W.userId = :USERID OR rewardedId = :USERID OR PM.idUser = :USERID) and typeId != 0  order by W.id DESC" );
		$sql->execute(array('USERID' => $userId));

		return ($sql->fetchAll()); 	 	
 	 }



 	 function get_count_likes($idWall){

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) FROM wall_likes where idWall= :ID order by id DESC' );
		$sql->execute(array('ID' => $idWall));
		return $sql->fetchColumn();		

		$conn = null;
		$sql = null;

 	 }

 	 function insert_likes($idWall, $idUser){

		$conn = new Conexion();

		$sql_query = $conn->prepare("SELECT id from wall_likes where idWall = :ID and idUser = :IDUSER" );
		$sql_query->execute(array('ID' => $idWall, 'IDUSER' => $idUser)); 	 	
		$tiene_likes = $sql_query->fetchColumn();

		if($tiene_likes):
			$sql = $conn->prepare("DELETE FROM wall_likes where idWall = :ID and idUser = :IDUSER" );
			$sql->execute(array('ID' => $idWall, 'IDUSER' => $idUser)); 
			return false;	 				
		else:	
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;

			$sql = $conn->prepare("INSERT INTO wall_likes values (NULL, :ID, 1, '$hora_actual', :IDUSER)" );
			$sql->execute(array('ID' => $idWall, 'IDUSER' => $idUser)); 	 	
			return true;
		endif;	

		$conn = null;
		$sql = null;
		$sql_query = null;

 	 }

 	 function check_like($idWall, $idUser){
		$conn = new Conexion();

		$sql_query = $conn->prepare("SELECT id from wall_likes where idWall = :ID and idUser = :IDUSER" );
		$sql_query->execute(array('ID' => $idWall, 'IDUSER' => $idUser)); 	 	
		
		return $sql_query->fetchColumn();


 	 }


 	 function insert_comments($idWall, $comment, $idUser, $user_wall){

		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;


		//MODIFICO EL TEXTO Y CONVIERTO EN html, para agregar los enlaces
		$cadena_origen= $comment;

		$cadena_resultante= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1" target=\"_blank\">$0</a>', $cadena_origen);
		$cadena_resultante= preg_replace("/href=\"www/", 'href="http://www', $cadena_resultante);
		$cadena_resultante = preg_replace("/(@[^.]+)/", '<a   href="' .HOME . 'buscador/$1/">$0</a>', $cadena_resultante);

		$conn = new Conexion();


		$sql = $conn->prepare("INSERT INTO wall_comments values (NULL, :ID, :COMMENT, 1, '$hora_actual', :IDUSER)" );
		$sql->execute(array('ID' => $idWall, 'IDUSER' => $idUser, 'COMMENT' => $cadena_resultante)); 	 	
		$lastId = $conn->lastInsertId();

		if($idUser != $user_wall):
			Notification::new_notification("CO", $lastId, $user_wall);		
		endif;

		if($lastId):

			Wall::obtenerUserArroba($cadena_origen, '@', '.', $lastId);
		endif;

		return true;

		$conn = null;
		$sql = null;


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
				Wall::new_comments_mentions($insertId, $user_id);	    	
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
	 
	function new_comments_mentions($insertId, $user_id){
		//	echo  $insertId . " ::  " . $user_id;die; 
			$conn = new Conexion();		
			$sql = $conn->prepare( "insert into wall_comments_mentions values (:COMMENT, :USER)"); 
 			$sql->execute(array('COMMENT' => $insertId, 'USER' => $user_id));
 			$conn = null;
 			$sql = null;


	}


 	 function get_coments_id($_id){

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT C.idUser, U.name, idWall, C.date, U.img_perfil FROM wall_comments C INNER JOIN users U ON C.idUser = U.id where C.id = :ID' );
		$sql->execute(array('ID' => $_id));

		return $sql->fetch(PDO::FETCH_ASSOC);
 	 }

 	 function get_count_comments($idWall){

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) FROM wall_comments where idWall= :ID and active = 1 order by id DESC' );
		$sql->execute(array('ID' => $idWall));
		return $sql->fetchColumn();		

		$conn = null;
		$sql = null;

 	 }
 	 function get_comments_wall($idWall, $limit=0){
		if($limit):
			$limit_clause = " limit $limit ";
		else:
			$limit_clause =" ";
		endif;

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT WC.*, U.name, U.img_perfil FROM wall_comments WC INNER JOIN users U on WC.idUser = U.id where idWall = :ID and WC.active = 1 order by WC.date ASC' . $limit_clause );
		$sql->execute(array('ID' => $idWall));

		return($sql->fetchAll());

		$conn = null;
		$sql = null;

 	 } 	 

 	 function delete_publication($idWall){
		$conn = new Conexion();

		$sql = $conn->prepare('UPDATE wall set active = 0 where id = :ID' );
		$sql->execute(array('ID' => $idWall));


		$conn = null;
		$sql = null; 	 	

 	 }

 	 function delete_comment($idComment){
		$conn = new Conexion();

		$sql = $conn->prepare('UPDATE wall_comments set active = 0 where id = :ID' );
		$sql->execute(array('ID' => $idComment));


		$conn = null;
		$sql = null; 	 	

 	 }



 	 function get_wall_by_typeId($typeId){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT W.*, U.name, U.img_perfil FROM wall W INNER JOIN users U ON W.userId = U.id WHERE W.active = 1 AND typeId = :TYPE  order by W.id DESC" );
		$sql->execute(array('TYPE' => $typeId));

		return ( $sql->fetch(PDO::FETCH_ASSOC)); 	 	
 	 }



 	/*---GETTERS--------------------------------------------------------------*/
 	
 	function get_id() { return($this->id); } 
 	function get_type() { return($this->type); } 
 	function get_typeId() { return($this->typeId); }
 	function get_date() { return($this->date); } 
 	function get_active() { return($this->active); } 

 	/*------------------------------------------------------------------------*/
 	/*---SETTERS--------------------------------------------------------------*/ 
 	function set_id($_id) { $this->id = $_id; } 
 	function set_type($_type) { $this->type = $_type; }
 	function set_typeId($_typeId) { $this->typeId = $_typeId; } 
 	function set_date($_date) { $this->date = $_date; }
 	function set_active($_active) { $this->active = $_active; } 
 	/*------------------------------------------------------------------------*/ 

 } // endclass


?>