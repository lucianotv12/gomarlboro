<?php
class Reward { 
	var $id; 
	var $userId; 
	var $rewardedId;
	var $conductId; 
	var $points; 
	var $description; 
	var $date; 
	var $active; 

	function Reward($_id=0) { 
		if ($_id<>0) { 

			$conn = new Conexion();

			$sql = $conn->prepare('select * from rewards where id= :ID');
			$sql->execute(array('ID' => $_id));
			$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);

			$this->id = $datos_carga['id']; 
			$this->userId = $datos_carga['userId'];
			$this->rewardedId = $datos_carga['rewardedId']; 
			$this->conductId = $datos_carga['conductId']; 
			$this->points = $datos_carga['points'];
			$this->description = $datos_carga['description']; 
			$this->date = $datos_carga['date']; 
			$this->active = $datos_carga['active'];

			$conn = null;
			$sql = null;


		} 
	}

	function save() {//Guarda o inserta segun corresponda 
		$conn = new Conexion();
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;

		if ($this->id<>0) { 

			$sql = $conn->prepare("update rewards set userId = '$this->userId', rewardedId = '$this->rewardedId', conductId = '$this->conductId', points = '$this->points', description = '$this->description', date = '$hora_actual', active = '$this->active' where id=$this->id");
 			$sql->execute();
			$lastId = "";

		} else { 
			$sql = $conn->prepare("insert into rewards values (null, '$this->userId', '$this->rewardedId', '$this->conductId', '$this->points', '$this->description', '$hora_actual', '$this->active')");
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


	function new_reward($_PARAM, $_user_id){

		if(!$_PARAM["puntos"]):
			$_PARAM["puntos"] = 0;
		endif;

		// COMPROBAR DUPLICADO
		$conn = new Conexion();

		$sql = $conn->prepare(" SELECT * FROM rewards where description = :DESCRIPCION and userId = :USERID and rewardedId = :RECOMPENZADO AND points = :POINTS and Date_format(date,'%Y-%m-%d') = curdate() order by id desc limit 1");
		$sql->execute(array('RECOMPENZADO' => $_PARAM["userId"], 'USERID' =>  $_user_id, 'DESCRIPCION' => $_PARAM["recompensa_descripcion"], 'POINTS' => $_PARAM["puntos"]));			
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if($resultado):
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;			

			$fecha1 = new DateTime($hora_actual);
			$fecha2 = new DateTime($resultado["date"]);
			$fecha = $fecha1->diff($fecha2);
		//	printf('%d años, %d meses, %d días, %d horas, %d minutos, %d segundos', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i, $fecha->s);
		
			if( $fecha->h == 0 and $fecha->i == 0 ): 

			     echo '<script type="text/javascript">window.location.assign("../home.html");</script>';     
			 	return "";
			 endif; 
		 endif;
		// COMPROBAR DUPLICADO


		$reward = new Reward();

		$reward->set_userId(Reward::test_input($_user_id));
		$reward->set_rewardedId(Reward::test_input($_PARAM["userId"]));
		$reward->set_conductId(Reward::test_input($_PARAM["recompensa_comportamientos"]));
		$reward->set_points(Reward::test_input($_PARAM["puntos"]));
		$reward->set_description(Reward::test_input($_PARAM["recompensa_descripcion"]));
		$reward->set_date(0);
		$reward->set_active(1);

		$insertId = $reward->save();

		//AGREGO REGISTRO EN MURO
		if($insertId):
		$reward->new_wall_r($insertId, $_user_id);
		endif;

		//AGREGO REGISTRO EN MURO

		if($insertId):

			$reward->discount_pointDonate($_user_id, $_PARAM["puntos"] );

			$reward->count_point($_PARAM["userId"], $_PARAM["puntos"] );

			Notification::new_notification("R", $insertId, $_PARAM["userId"]);		


			//ENVIAR MAIL
			$reconocido = User::get_user_by_id($_PARAM["userId"]);
			$reconocedor = User::get_user_by_id($_user_id); 
			if($_PARAM["puntos"]):
				$puntos_reconocidodos= " con " . $_PARAM["puntos"] . "puntos"; 
			else:
				$puntos_reconocidodos= " ";
			endif;
				
			require_once  '../mandrill/Mandrill.php'; 
			$mandrill = new Mandrill('Sh9utjw6BGxpiFPPTa3YFg');

			try{ 
			    $message = array(
			        'subject' => 'Te reconocieron',
			        'html' => $reconocido["name"] . ' Te reconocieron en la plataforma REC, te reconoció : '. $reconocedor["name"] . $puntos_reconocidodos   ,
			        'from_email' => 'notificaciones@pmiarrec.com',
			        'to' => array(
			            array(
			                'email' => $reconocido["email"],
			                'name' => $reconocido["name"]
			            )
			        )
			    );
			    $result = $mandrill->messages->send($message);    
			} catch(Mandrill_Error $e) { 
			    echo 'Ocurrio un error en el envio de email'; 
			}



		endif;	



	}

	function new_wall_r($insertId, $_user_id){
		// nuevo registro en muro
		$insertId = Reward::test_input($insertId);		
		$_user_id = Reward::test_input($_user_id);		
		date_default_timezone_set('America/Argentina/Buenos_Aires');
		$_hora= date ("H:i:s");
		$_fecha= date ("Y-m-d");
		$hora_actual = $_fecha . " " . $_hora;
				
		$conn = new Conexion();

		$sql = $conn->prepare("insert into wall (id, type, typeId, date, active, userId) values (null, 'R', '$insertId', '$hora_actual', '$this->active', '$_user_id')");
		$sql->execute();



	}

	function discount_pointDonate($user_id, $points){
			$user_id = Reward::test_input($user_id);
			$points = Reward::test_input($points);


			$conn = new Conexion();

			$sql = $conn->prepare('UPDATE users_points set pointsDonate = pointsDonate - :points   where userId= :ID');
			$sql->execute(array('ID' => $user_id, 'points' => $points));

			$conn = null;
			$sql = null;
	}

	function count_point($user_id, $points){
			$user_id = Reward::test_input($user_id);
			$points = Reward::test_input($points);

			$conn = new Conexion();

			$sql = $conn->prepare('UPDATE users_points set points = points + :points   where userId= :ID');
			$sql->execute(array('ID' => $user_id, 'points' => $points));

			$conn = null;
			$sql = null;
	}

	function get_reward_id($_id){


		$conn = new Conexion();

		$sql = $conn->prepare("SELECT R.*, W.id as wallId, U.name as usuario, U2.name as recomendado, U2.gender as sexo, C.name as conducta, U.img_perfil FROM rewards R INNER JOIN users as U on R.userId = U.id INNER JOIN users as U2 on R.rewardedId = U2.id INNER JOIN conducts as C ON R.conductId = C.id INNER JOIN wall as W on W.typeId = R.id and type= 'R' WHERE R.id = :ID");
		$sql->execute(array('ID' => $_id));

		return $resultado = $sql->fetch(PDO::FETCH_ASSOC);


		$conn = null;
		$sql = null;


	}

	function get_recompense($user_id){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT R.*, U.name as usuario, U2.name as recomendado, C.name, U2.img_perfil FROM rewards R INNER JOIN users as U on R.userId = U.id INNER JOIN users as U2 on R.rewardedId = U2.id INNER JOIN conducts as C ON C.id = R.conductId WHERE R.userId = :ID' );
		$sql->execute(array('ID' => $user_id));

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}

	function get_recompensa_recibida($user_id){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT R.*, U.name as usuario, U2.name as recomendado, C.name, U.img_perfil FROM rewards R INNER JOIN users as U on R.userId = U.id INNER JOIN users as U2 on R.rewardedId = U2.id INNER JOIN conducts as C ON C.id = R.conductId WHERE R.rewardedId = :ID' );
		$sql->execute(array('ID' => $user_id));

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}

	function get_mas_felicitados(){
		$conn = new Conexion();
		$sql = $conn->prepare('SELECT R.rewardedId, count(R.id) as cantidad, U.name, U.img_perfil FROM `rewards` as R INNER JOIN users U on U.id = R.rewardedId group by rewardedId order by cantidad desc limit 3');
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;
	}	

	function get_mas_felicitados_funtion($_funcion){
		$conn = new Conexion();
		$sql = $conn->prepare('SELECT R.rewardedId, count(R.id) as cantidad, U.name, U.img_perfil FROM `rewards` as R INNER JOIN users U on U.id = R.rewardedId WHERE U.function = :FUNCION group by rewardedId order by cantidad desc limit 3');
		$sql->execute(array('FUNCION' => $_funcion));

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;
	}	

	function get_mas_felicitados_subarea($_subarea){
		$conn = new Conexion();
		$sql = $conn->prepare('SELECT R.rewardedId, count(R.id) as cantidad, U.name, U.img_perfil FROM `rewards` as R INNER JOIN users U on U.id = R.rewardedId WHERE U.subarea = :SUBAREA group by rewardedId order by cantidad desc limit 3');
		$sql->execute(array('SUBAREA' => $_subarea));

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;
	}	

	function get_mas_avalados(){
		$conn = new Conexion();
		$sql = $conn->prepare("SELECT R.rewardedId, count(WL.id) as cantidad, U.name, U.img_perfil  FROM `wall` W INNER JOIN wall_likes WL on WL.idWall = W.id INNER JOIN rewards R ON R.id = W.typeID and W.type= 'R' INNER JOIN users U on U.id = R.rewardedId where W.type= 'R' GROUP by R.rewardedId ORDER by cantidad DESC limit 3");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;
	}		

	function get_rewards(){

		$conn = new Conexion();
		$sql = $conn->prepare("SELECT R.*, U.name as reconocedor, U2.name as reconocido, count(*) AS avales, C.name as conducta, U.function, U.supervisor  FROM `wall` W INNER JOIN rewards R on W.typeId = R.id and W.type = 'R' INNER JOIN users U on R.userId = U.id INNER JOIN users U2 on R.rewardedId = U2.id LEFT JOIN wall_likes WL ON W.id = WL.idWall INNER JOIN conducts as C ON C.id = R.conductId GROUP BY R.id");
		$sql->execute();

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;

	}

	function conductas_avales($conducta_id){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT count(*) as cantidad FROM `rewards` R INNER JOIN wall W on R.id = W.typeId and W.type = 'R' INNER JOIN wall_likes WL on WL.idWall = W.id WHERE conductId = :CONDUCTA GROUP BY conductId" );
		$sql->execute(array('CONDUCTA' => $conducta_id));
		$resultado = $sql->fetch(PDO::FETCH_ASSOC);

		if(!$resultado["cantidad"]):
			$resultado["cantidad"] = 0;
		endif;	

		return $resultado["cantidad"];

		$conn = null;
		$sql = null;

	}

	function conductas_funciones($conducta_id){

		$conn = new Conexion();

		$sql = $conn->prepare("SELECT C.*, COUNT(*) as cuenta, U.function FROM conducts C LEFT join rewards R ON R.conductId = C.id INNER JOIN users U ON R.userId = U.id WHERE C.id = :CONDUCTA group by U.function ORDER by cuenta desc" );
		$sql->execute(array('CONDUCTA' => $conducta_id));

		return $resultado = $sql->fetchAll();

		$conn = null;
		$sql = null;



	}

	/*---GETTERS--------------------------------------------------------------*/ 
	function get_id() { return($this->id); }
	function get_userId() { return($this->userId); }
	function get_rewardedId() { return($this->rewardedId); } 
	function get_conductId() { return($this->conductId); }
	function get_points() { return($this->points); }
	function get_description() { return($this->description); } 
	function get_date() { return($this->date); }
	function get_active() { return($this->active); }

	/*------------------------------------------------------------------------*/
	/*---SETTERS--------------------------------------------------------------*/ 
	function set_id($_id) { $this->id = $_id; } 
	function set_userId($_userId) { $this->userId = $_userId; }
	function set_rewardedId($_rewardedId) { $this->rewardedId = $_rewardedId; } 
	function set_conductId($_conductId) { $this->conductId = $_conductId; } 
	function set_points($_points) { $this->points = $_points; }
	function set_description($_description) { $this->description = $_description; } 
	function set_date($_date) { $this->date = $_date; }
	function set_active($_active) { $this->active = $_active; } 
	/*------------------------------------------------------------------------*/ 


	function get_conducts(){ 
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT C.*, COUNT(*) as cuenta FROM conducts C LEFT join rewards R ON R.conductId = C.id WHERE C.active = 1 group by C.id ORDER by cuenta desc' );
		$sql->execute();
		$resultado = $sql->fetchAll();
		if($resultado):
			return($resultado);
		else:
			return(false);
		
		endif;	
		$conn = null;
		$sql = null;

	}

	function get_total_rewards(){ 
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT COUNT(*) AS cantidad FROM rewards where active = 1' );
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);

		$conn = null;
		$sql = null;

	}

	function get_total_avales(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT COUNT(*) AS cantidad FROM wall W INNER JOIN wall_likes WL ON W.id = WL.idWall where W.active = 1 and W.type = "R"' );
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC);

		$conn = null;
		$sql = null;


	}

	function get_total_rewards_comportamiento($comportamiento_id){ 
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT COUNT(*) AS cantidad FROM rewards where active = 1 and conductId = :CONDUCTA' );
		$sql->execute(array('CONDUCTA' => $comportamiento_id));
		return $sql->fetch(PDO::FETCH_ASSOC);

		$conn = null;
		$sql = null;

	}

	function get_rewards_function(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) as cantidad, U.function FROM rewards R INNER JOIN users U on R.userId = U.id where R.active = 1 GROUP by function' );
		$sql->execute();
		return $sql->fetchAll();

		$conn = null;
		$sql = null;		
		
	}

	function get_rewards_function_comportamiento($comportamiento_id){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) as cantidad, U.function FROM rewards R INNER JOIN users U on R.userId = U.id where R.active = 1 and R.conductId = :CONDUCTA GROUP by function' );
		$sql->execute(array('CONDUCTA' => $comportamiento_id));
		return $sql->fetchAll();

		$conn = null;
		$sql = null;		
		
	}


	function get_rewards_subarea(){
		$conn = new Conexion();

		$sql = $conn->prepare('SELECT count(*) as cantidad, U.subarea FROM rewards P INNER JOIN users U on P.userId = U.id where P.active = 1 GROUP by subarea' );
		$sql->execute();
		return $sql->fetchAll();

		$conn = null;
		$sql = null;		
		
	}


}//endClass



?>
