<?php
class User_gt { 

	var $id;
	var $usuario;
	var $clave; 
	var $codigo_EZD; 	 
	var $desc_EZD; 	 
	var $razon_social; 	 
	var $calle; 	 
	var $numero;
	var $localidad;
	var $provincia;
	var $objetivo;
	var $puntos;
	var $active;	
	var $date;
	var $acepta_bases;

	function User_gt($_id=0) { 
		if ($_id<>0) { 

			$conn = new Conexion();

			$sql = $conn->prepare('select * from users_gt where id= :ID');
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);


			$this->id = $datos_carga['id']; 
			$this->usuario = $datos_carga['usuario'];
			$this->clave = $datos_carga['clave'];
			$this->codigo_EZD = $datos_carga['codigo_EZD'];
			$this->desc_EZD = $datos_carga['desc_EZD']; 
			$this->razon_social = $datos_carga['razon_social']; 
			$this->calle = $datos_carga['calle']; 
			$this->numero = $datos_carga['numero']; 
			$this->localidad = $datos_carga['localidad']; 
			$this->provincia = $datos_carga['provincia']; 
			$this->objetivo = $datos_carga['objetivo']; 
			$this->puntos = $datos_carga['puntos']; 
			$this->active = $datos_carga['active']; 
			$this->date = $datos_carga['date']; 			
			$this->acepta_bases = $datos_carga['acepta_bases']; 			
		
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
		//	mysql_query($query_save) or die(mysql_error()); 
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

			$sql = $conn->prepare('UPDATE users SET clave = :NEWPASS, date = :FECHA, active = 1  WHERE id = :User' );
			$sql->execute(array('User' => $user_id, 'NEWPASS' => $nueva_clave, 'FECHA' => $hora_actual));

			$resultado = $sql->fetch(PDO::FETCH_ASSOC);
			return true;
		else:
			return false;
		
		endif;	
		$conn = null;
		$sql = null;		


	}

	function actualizar_datos($user_id,$_PARAM){
		$conn = new Conexion();
		$sql = $conn->prepare("UPDATE users set nombre = :NOMBRE, fechaNac = :FECHANAC, celular = :CELULAR, email = :EMAIL WHERE id = :User");
		$sql->execute(array('User' => $user_id, 'NOMBRE' => $_PARAM["nombre"], 'FECHANAC' => $_PARAM["fecha"], 'CELULAR' => $_PARAM["celular"], 'EMAIL' => $_PARAM["email"]));


	}

	function acepta_basesycondiciones($_id){
		$_id		= preg_replace('/[^0-9]/'		,''	, $_id);
		$conn = new Conexion();
		$sql = $conn->prepare("UPDATE users set acepta_bases = 1 where id = :ID"); 
		$sql->execute(array('ID' => $_id)); 		
		$sql=null;
		$conn=null;
	}	


	function login_admin($_user,$_password)
	{
	
		$_password_SHA = sha1($_password);
			

		$conn = new Conexion();

		$sql = $conn->prepare('SELECT id FROM users_gt WHERE usuario = :User and (clave = :Pass OR clave = :PassSHA)' );
		$sql->execute(array('User' => $_user,  'PassSHA' => $_password_SHA, 'Pass' => $_password));
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);
		if($resultado):
				return $resultado["id"];
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


	function get_user_by_name($name){

			$conn = new Conexion();

			$sql = $conn->prepare('select id from users where nombre= :NAME');
			$sql->execute(array('NAME' => $name));
			return $sql->fetch(PDO::FETCH_ASSOC);

	}


	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	/*---GETTERS--------------------------------------------------------------*/ 

	function get_id() { return($this->id); }
	function get_usuario() { return($this->usuario); } 	
	function get_clave() { return($this->clave); } 		
	function get_codigo_EZD() { return($this->codigo_EZD); }
	function get_desc_EZD() { return($this->desc_EZD); }
	function get_razon_social() { return($this->razon_social); } 
	function get_calle() { return($this->calle); } 
	function get_numero() { return($this->numero); } 
	function get_localidad() { return($this->localidad); } 
	function get_provincia() { return($this->provincia); } 
	function get_objetivo() { return($this->objetivo); } 
	function get_puntos() { return($this->puntos); } 
	function get_active() { return($this->active); } 
	function get_date() { return($this->date); } 
	function get_acepta_bases() { return($this->acepta_bases); } 

	
	/*------------------------------------------------------------------------*/ 
	
	/*---SETTERS--------------------------------------------------------------*/ 
	function set_id($_id) { $this->id = $_id; } 
	function set_usuario($_usuario) { $this->usuario = $_usuario; } 
	function set_clave($_clave) { $this->clave = $_clave; }
	function set_codigo_EZD($_codigo_EZD) { $this->codigo_EZD = $_codigo_EZD; }
	function set_desc_EZD($_desc_EZD) { $this->desc_EZD = $_desc_EZD; } 
	function set_razon_social($_razon_social) { $this->razon_social = $_razon_social; }
	function set_calle($_calle) { $this->calle = $_calle; } 
	function set_numero($_numero) { $this->numero = $_numero; } 
	function set_localidad($_localidad) { $this->localidad = $_localidad; } 
	function set_provincia($_provincia) { $this->provincia = $_provincia; } 
	function set_objetivo($_objetivo) { $this->objetivo = $_objetivo; } 
	function set_puntos($_puntos) { $this->puntos = $_puntos; } 
	function set_active($_active) { $this->active = $_active; } 
	function set_date($_date) { $this->date = $_date; } 	
	function set_acepta_bases($_acepta_bases) { $this->acepta_bases = $_acepta_bases; } 	

	/*------------------------------------------------------------------------*/ 

}//endclass


?>
