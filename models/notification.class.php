<?php
class Notification {

	 var $id; 
 	 var $type;
 	 var $typeId; 
 	 var $userId;
 	 var $date; 
 	 var $active; 


 	 function Notification($_id=0) { 
 	 	if ($_id<>0) { 

			$conn = new Conexion();

			$sql = $conn->prepare('select * from notifications where id= :ID');
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);

 			$this->id = $datos_carga['id']; 
 			$this->type = $datos_carga['type']; 
 			$this->typeId = $datos_carga['typeId']; 
 			$this->userId = $datos_carga['userId'];  	 			
 			$this->date = $datos_carga['date']; 
 			$this->active = $datos_carga['active']; 

			$conn = null;
			$sql = null;

 	 	} 
 	 } 

 	 function save() {//Guarda o inserta segun corresponda 

		$conn = new Conexion();

 	 	if ($this->id<>0) { 
 	 		$sql = $conn->prepare("update notifications set type = '$this->type', typeId = '$this->typeId', userId = '$this->userId', date = '$this->date', active = '$this->active' where id=$this->id"); 
 			$sql->execute();
			$lastId = "";

 	 	} else { 

			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;

 	 		$sql = $conn->prepare("insert into notifications values (null, '$this->type', '$this->typeId', '$this->userId', '$this->active', '$hora_actual')"); 
 			$sql->execute();
			$lastId = $conn->lastInsertId();
 	 	} 
 	 }


	function new_notification($type, $type_id, $user_id){
			//id, type, typeId, userId, active, date
		$notification = new Notification();

		$notification->set_type($type);
		$notification->set_typeId($type_id);
		$notification->set_userId($user_id);
		$notification->set_active(1);
		$notification->set_date(0);

		$insertId = $notification->save();


	}

	function get_notifications($_userId, $limit=0){
		$conn = new Conexion();

		if($limit):
			$limit_clause = " order by date desc limit $limit ";
		else:
			$limit_clause ="";
		endif;

		$sql = $conn->prepare('SELECT * from notifications where userId= :ID ' . $limit_clause);
		$sql->execute(array('ID' => $_userId));
		return($sql->fetchAll());
			$conn = null;
			$sql = null;

	}

	function notifications_views($_userId){
		$conn = new Conexion();


		$sql = $conn->prepare('UPDATE notifications set active = 0 where userId= :ID ');
		$sql->execute(array('ID' => $_userId));
		return($sql->fetchAll());
			$conn = null;
			$sql = null;

	}	

	function get_counts_notifications($_userId){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) from notifications where userId= :ID and active = 1');
		$sql->execute(array('ID' => $_userId));
		return($sql->fetchColumn());
			$conn = null;
			$sql = null;

	}

 	/*---GETTERS--------------------------------------------------------------*/
 	
 	function get_id() { return($this->id); } 
 	function get_type() { return($this->type); } 
 	function get_typeId() { return($this->typeId); }
 	function get_userId() { return($this->userId); } 	
 	function get_date() { return($this->date); } 
 	function get_active() { return($this->active); } 

 	/*------------------------------------------------------------------------*/
 	/*---SETTERS--------------------------------------------------------------*/ 
 	function set_id($_id) { $this->id = $_id; } 
 	function set_type($_type) { $this->type = $_type; }
 	function set_typeId($_typeId) { $this->typeId = $_typeId; } 
 	function set_userId($_userId) { $this->userId = $_userId; } 
 	function set_date($_date) { $this->date = $_date; }
 	function set_active($_active) { $this->active = $_active; } 
 	/*------------------------------------------------------------------------*/ 

 } // endclass


?>