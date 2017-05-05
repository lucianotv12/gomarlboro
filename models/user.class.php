<?php
class User { 
	//id, name, clave, legajo, birdate, entryDate, email, positionNumber, position, costCenter, costCenterName, subordinates, city, function, hc, companyCode, active, dateRegister, img_perfil, img_portada, gender
	var $id;
	var $nombre;
	var $usuario;
	var $clave; 
	var $mecanica; 	 
	var $fechaNac; 	 
	var $email; 	 
	var $celular; 	 
	var $active;
	var $date;
	function User($_id=0) { 
		if ($_id<>0) { 

			$conn = new Conexion();

			$sql = $conn->prepare('select * from users where id= :ID');
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);


			$this->id = $datos_carga['id']; 
			$this->nombre = $datos_carga['nombre'];
			$this->usuario = $datos_carga['usuario'];
			$this->clave = $datos_carga['clave'];
			$this->mecanica = $datos_carga['mecanica'];
			$this->fechaNac = $datos_carga['fechaNac']; 
			$this->email = $datos_carga['email']; 
			$this->celular = $datos_carga['celular']; 
			$this->active = $datos_carga['active']; 
			$this->date = $datos_carga['date']; 			
		
			$conn = null;
			$sql = null;

		} 
	} 

	function save() {//Guarda o inserta segun corresponda 
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;
		$conn = new Conexion();
	
		if ($this->id<>0) { 
//			$query_save = "update users set name = '$this->name', legajo = '$this->legajo', birdate = '$this->birdate', entryDate = '$this->entryDate', email = '$this->email', positionNumber = '$this->positionNumber', position = '$this->position', costCenter = '$this->costCenter', costCenterName = '$this->costCenterName', subordinates = '$this->subordinates', city = '$this->city', function = '$this->function', hc = '$this->hc', companyCode = '$this->companyCode' where id='$this->id'"; 
			mysql_query($query_save) or die(mysql_error()); 
		} else { 
//			$sql = $conn->prepare( "INSERT into users values (null, '$this->name', '$this->clave' , '$this->legajo', '$this->birdate', '$this->entryDate', '$this->email', '$this->positionNumber', '$this->position', '$this->costCenter', '$this->costCenterName', '$this->subordinates', '$this->city', '$this->function', '0', '$this->companyCode', '1', '', '', '' , '$this->gender' , '$this->area', '$this->subarea', '$this->entrega', '$this->status', '$this->ceco', '$this->cecoFacturacion', '$this->region', '$this->supervisor','$this->employeGroup' )"); 

			$sql->execute();
				$lastId = $conn->lastInsertId();

		} 
			$conn = null;
			$sql = null;	
			return $lastId;			
	}

	function change_pass($user_id, $clave, $nueva_clave){
		$conn = new Conexion();
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;

		$clave_actual = sha1($clave);
		$nueva_clave = sha1($nueva_clave);


		$sql = $conn->prepare('SELECT id FROM users WHERE id = :User and (clave = :Pass or clave = :PassSHA)' );
		$sql->execute(array('User' => $user_id, 'PassSHA' => $clave_actual, 'Pass' => $clave));

		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if($resultado):

			$sql = $conn->prepare('UPDATE users SET clave = :NEWPASS, date = :FECHA  WHERE id = :User' );
			$sql->execute(array('User' => $user_id, 'NEWPASS' => $nueva_clave, 'FECHA' => $hora_actual));

			$resultado = $sql->fetch(PDO::FETCH_ASSOC);
			return true;
		else:
			return false;
		
		endif;	
		$conn = null;
		$sql = null;		


	}



	function login_admin($_user,$_password)
	{
	//	$_user = mysql_real_escape_string($_user);
//		$_password = mysql_real_escape_string($_password);		
		$_password_SHA = sha1($_password);
			

		$conn = new Conexion();

//		ECHO "SELECT id FROM users WHERE email = :User and (clave = :Pass OR clave = $_password_SHA";

		$sql = $conn->prepare('SELECT id FROM users WHERE usuario = :User and (clave = :Pass OR clave = :PassSHA)' );
		$sql->execute(array('User' => $_user,  'PassSHA' => $_password_SHA, 'Pass' => $_password));
		$resultado = $sql->fetchAll();
		if($resultado):
			foreach ($resultado as $row) {
				return $row["id"];
			}
		else:
			return(false);
		
		endif;	
		$conn = null;
		$sql = null;

	}	

	function get_user_by_id($_id){
			$conn = new Conexion();

			if(is_numeric($_id)):

				$sql = $conn->prepare('select * from users where id= :ID');
				$sql->execute(array('ID' => $_id));
				return $sql->fetch(PDO::FETCH_ASSOC);
			else: 
				$arroba = explode("@", $_id);
				$arroba = $arroba[1];


				$sql = $conn->prepare('select * from users where name = :ARROBA');
				$sql->execute(array('ARROBA' => $arroba));
				return $sql->fetch(PDO::FETCH_ASSOC);
			endif;	

	}

	function get_user_by_id_backend($_id){
			$conn = new Conexion();

				$sql = $conn->prepare('SELECT * from users U inner join users_points UP ON U.id = UP.userId where U.id= :ID');
				$sql->execute(array('ID' => $_id));
				return $sql->fetch(PDO::FETCH_ASSOC);

	}

	function get_user_by_name($name){

			$conn = new Conexion();

			$sql = $conn->prepare('select id from users where name= :NAME');
			$sql->execute(array('NAME' => $name));
			return $sql->fetch(PDO::FETCH_ASSOC);

	}


	function get_points($_user_id,$tipo=1){

		$user_id = User::test_input($_user_id);
		if($tipo == 1):
			$select_clause = "points";
		elseif($tipo == 2):
			$select_clause = "pointsDonate";

		endif;	


		$conn = new Conexion();

		$sql = $conn->prepare("SELECT $select_clause FROM users_points WHERE userId = :User" );
		$sql->execute(array('User' => $user_id));	

		$resultado = $sql->fetchAll();
		if($resultado):
			foreach ($resultado as $row) {
				return $row[$select_clause];
			}
		else:
			return(false);
		
		endif;	
		$conn = null;
		$sql = null;



	}


	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function buscarUserAjax($palabra, $user_id){

//		$palabra = htmlspecialchars(stripslashes(trim($palabra)));
//		$user_id = htmlspecialchars(stripslashes(trim($user_id)));

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT * from users where name like '%$palabra%' and id != :USER limit 50 " );
		$sql->execute(array( 'USER' => $user_id));
		$resultado = $sql->fetchAll();
		$usuarios = array();

		if($resultado):
			foreach ($resultado as $row) {
				$usuarios[] = array("value" => $row['name'],
							 "name" => $row['name'] ,
							 "id"	 =>	$row['id'],
									);
			}
			return($usuarios);
		else:
			return(false);
		
		endif;	
		$conn = null;
		$sql = null;

	}

	function buscarUserAjax_comentarios($palabra, $user_id){

//		$palabra = htmlspecialchars(stripslashes(trim($palabra)));
//		$user_id = htmlspecialchars(stripslashes(trim($user_id)));

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT * from users where name like '%$palabra%' and id != :USER limit 50 " );
		$sql->execute(array( 'USER' => $user_id));
		$resultado = $sql->fetchAll();
		$usuarios = array();

		if($resultado):
			foreach ($resultado as $row) {
				$usuarios[] = array("value" => $row['name'] . ".",
							 "name" => $row['name'] ,
							 "id"	 =>	$row['id'],
									);
			}
			return($usuarios);
		else:
			return(false);
		
		endif;	
		$conn = null;
		$sql = null;

	}

	function me_avalaron($_user_id, $conducta_id){


		$conn = new Conexion();

		$sql = $conn->prepare("SELECT count(*) as cantidad FROM `rewards` R INNER JOIN wall W on R.id = W.typeId and W.type = 'R' INNER JOIN wall_likes WL on WL.idWall = W.id WHERE R.rewardedId = :USER and conductId = :CONDUCTA GROUP BY rewardedId" );
		$sql->execute(array( 'USER' => $_user_id, 'CONDUCTA' => $conducta_id));
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if(!$resultado["cantidad"]):
			$resultado["cantidad"] = 0;
		endif;	

		return $resultado["cantidad"];

		$conn = null;
		$sql = null;

	}

	function ranking_comportamientos($conducta_id){


		$conn = new Conexion();

		$sql = $conn->prepare("SELECT count(*) as cantidad FROM rewards WHERE conductId = :CONDUCTA GROUP by conductId" );
		$sql->execute(array( 'CONDUCTA' => $conducta_id));
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if(!$resultado["cantidad"]):
			$resultado["cantidad"] = 0;
		endif;	

		return $resultado["cantidad"];

		$conn = null;
		$sql = null;

	}


	function get_users(){

		$conn = new Conexion();
		$sql = $conn->prepare("SELECT U.*, UP.points, UP.pointsDonate FROM users U inner join users_points UP ON U.id = UP.userId");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;


	}

	function get_subarea_canjes(){
		$conn = new Conexion();
		$sql = $conn->prepare("SELECT subarea FROM `users` U INNER join exchanges E on E.idUser = U.id Where E.status = 1 group by subarea");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}

	function get_funtions_by_users(){
		$conn = new Conexion();
		$sql = $conn->prepare("SELECT function FROM users group by function");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}

	function get_subarea_by_users(){
		$conn = new Conexion();
		$sql = $conn->prepare("SELECT subarea FROM users group by subarea");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;
		
	}	

	function get_delivery(){
		$conn = new Conexion();
		$sql = $conn->prepare("SELECT * FROM delivery");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}


	 /*---GETTERS--------------------------------------------------------------*/ 

	function get_id() { return($this->id); }
	function get_name() { return($this->name); } 
	function get_clave() { return($this->clave); } 	
	function get_legajo() { return($this->legajo); }
	function get_birdate() { return($this->birdate); }
	function get_entryDate() { return($this->entryDate); } 
	function get_email() { return($this->email); } 
	function get_positionNumber() { return($this->positionNumber); }
	function get_position() { return($this->position); }
	function get_costCenter() { return($this->costCenter); } 
	function get_costCenterName() { return($this->costCenterName); } 
	function get_subordinates() { return($this->subordinates); } 
	function get_city() { return($this->city); }
	function get_function() { return($this->function); } 
	function get_hc() { return($this->hc); } 
	function get_companyCode() { return($this->companyCode); }
	function get_active() { return($this->active); } 
	function get_dateRegister() { return($this->dateRegister); } 
	function get_img_perfil() { return($this->img_perfil); } 
	function get_img_portada() { return($this->img_portada); } 
	function get_gender() { return($this->gender); } 
	function get_area() { return($this->area); } 
	function get_subarea() { return($this->subarea); } 
	function get_entrega() { return($this->entrega); } 
	function get_status() { return($this->status); } 
	function get_ceco() { return($this->ceco); } 
	function get_cecoFacturacion() { return($this->cecoFacturacion); } 
	function get_region() { return($this->region); } 
	function get_supervisor() { return($this->supervisor); } 
	function get_employeGroup() { return($this->employeGroup); } 
	
	/*------------------------------------------------------------------------*/ 
	
	/*---SETTERS--------------------------------------------------------------*/ 
	
	function set_id($_id) { $this->id = $_id; } 
	function set_name($_name) { $this->name = $_name; } 
	function set_clave($_clave) { $this->clave = $_clave; } 
	function set_legajo($_legajo) { $this->legajo = $_legajo; }
	function set_birdate($_birdate) { $this->birdate = $_birdate; }
	function set_entryDate($_entryDate) { $this->entryDate = $_entryDate; } 
	function set_email($_email) { $this->email = $_email; }
	function set_positionNumber($_positionNumber) { $this->positionNumber = $_positionNumber; } 
	function set_position($_position) { $this->position = $_position; } 
	function set_costCenter($_costCenter) { $this->costCenter = $_costCenter; } 
	function set_costCenterName($_costCenterName) { $this->costCenterName = $_costCenterName; } 
	function set_subordinates($_subordinates) { $this->subordinates = $_subordinates; }
	function set_city($_city) { $this->city = $_city; }
	function set_function($_function) { $this->function = $_function; }
	function set_hc($_hc) { $this->hc = $_hc; }
	function set_companyCode($_companyCode) { $this->companyCode = $_companyCode; } 
	function set_active($_active) { $this->active = $_active; } 
	function set_dateRegister($_dateRegister) { $this->dateRegister = $_dateRegister; } 	
	function set_img_perfil($_img_perfil) { $this->img_perfil = $_img_perfil; } 
	function set_img_portada($_img_portada) { $this->img_portada = $_img_portada; } 
	function set_gender($_gender) { $this->gender = $_gender; } 
	function set_area($_area) { $this->area = $_area; } 
	function set_subarea($_subarea) { $this->subarea = $_subarea; } 
	function set_entrega($_entrega) { $this->entrega = $_entrega; } 
	function set_status($_status) { $this->status = $_status; } 
	function set_ceco($_ceco) { $this->ceco = $_ceco; } 
	function set_cecoFacturacion($_cecoFacturacion) { $this->cecoFacturacion = $_cecoFacturacion; } 
	function set_region($_region) { $this->region = $_region; } 
	function set_supervisor($_supervisor) { $this->supervisor = $_supervisor; } 
	function set_employeGroup($_employeGroup) { $this->employeGroup = $_employeGroup; } 

	/*------------------------------------------------------------------------*/ 

}//endclass


?>
