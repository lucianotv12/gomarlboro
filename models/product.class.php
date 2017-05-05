<?php 
	class Product { 
		var $id; 
		var $name; 
		var $desc; 
		var $code; 
		var $categoryId; 
		var $points; 
		var $stock; 
		var $terms; 
		var $active; 
		var $date; 
		var $brand;
		var $price;
		var $model;
		var $visitas;

		function Product($_id=0) { 
			if ($_id<>0) { 

				$conn = new Conexion();

				$sql = $conn->prepare('select * from products where id= :ID');
				$sql->execute(array('ID' => $_id));
				$datos_carga = $sql->fetch(PDO::FETCH_ASSOC);

				$this->id = $datos_carga['id']; 
				$this->name = $datos_carga['name']; 
				$this->desc = $datos_carga['desc']; 
				$this->code = $datos_carga['code']; 
				$this->categoryId = $datos_carga['categoryId']; 
				$this->points = $datos_carga['points']; 
				$this->stock = $datos_carga['stock']; 
				$this->terms = $datos_carga['terms']; 
				$this->active = $datos_carga['active']; 
				$this->date = $datos_carga['date'];
				$this->brand = $datos_carga['brand'];
				$this->price = $datos_carga['price'];
				$this->model = $datos_carga['model'];
				$this->visitas = $datos_carga['visitas'];


			} 
		} 


		function save() {//Guarda o inserta segun corresponda 
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;
			$conn = new Conexion();
			if ($this->id<>0) { 


			$sql = $conn->prepare( "UPDATE products P set name = '$this->name', P.desc = '$this->desc', code = '$this->code', categoryId = '$this->categoryId', points = '$this->points', stock = '$this->stock', active = '$this->active', date = '$hora_actual', brand = '$this->brand', price = '$this->price', model = '$this->model' where id='$this->id'"); 
	//		print_r($sql);die;
				$sql->execute();
				$lastId = "";
			} else { 


				$sql = $conn->prepare( "INSERT INTO products values (null, '$this->name', '$this->desc', '$this->code', '$this->categoryId', '$this->points', '$this->stock', '', '1', '$hora_actual', '$this->brand', '$this->price', '$this->model', '$this->visitas' )"); 
			
				$sql->execute();
				$lastId = $conn->lastInsertId();
 
			} 

			$conn = null;
			$sql = null;	
			return $lastId;	

		}

		function new_product($_PARAM, $_archivo=0){

			$product = new Product();
	
			$product->set_name($_PARAM["name"]);
			$product->set_desc($_PARAM["desc"]);
			$product->set_code($_PARAM["code"]);
			$product->set_categoryId($_PARAM["categoryId"]);
			$product->set_points($_PARAM["points"]);	
			$product->set_stock($_PARAM["stock"]);
			$product->set_terms('');
			$product->set_active(1);
			$product->set_brand($_PARAM["brand"]);			
			$product->set_price($_PARAM["price"]);
			$product->set_model($_PARAM["model"]);
			$product->set_visitas(0);


	 		$insertId = $product->save();
		
			if($_archivo):  
				$name_img = Product::upload_file($_archivo, $_PARAM["code"] );

			endif;			


		}

		function upload_file($_archivo, $insertId){


			if ($_archivo["imagen"]["error"] > 0){

			} else { 

				$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png", "video/mp4" );
				$limite_kb = 100000;

				if (in_array($_archivo['imagen']['type'], $permitidos)){ 

					$ext = pathinfo($_archivo['imagen']['name'], PATHINFO_EXTENSION);				
					$name_img = $insertId . "." . $ext;

					$ruta = "../template/img/catalogo/productos/" . $name_img;
				
					if (!file_exists($ruta)){ 

						$resultado = move_uploaded_file($_archivo["imagen"]["tmp_name"], $ruta);
						if ($resultado){
							return ($name_img) ;
						} else {
						}
					} else {
						unlink($ruta);					
						$resultado = move_uploaded_file($_archivo["imagen"]["tmp_name"], $ruta);					
						return ($name_img) ;
					}
				} else {
					echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
				}
			}
		}


		function get_categories(){
				$conn = new Conexion();

				$sql = $conn->prepare('select * from productscategory');
				$sql->execute();
				$datos_carga = $sql->fetchAll();
				return($datos_carga);

		}

		function get_products($_PARAM=0){

			
			if(@$_PARAM["producto_catalogo"]):
				$whereclause_name = " AND name like '%" . $_PARAM["producto_catalogo"] . "%'";
			else:
				$whereclause_name = " ";
			endif;	

			if(@$_PARAM["categorias"] != 0):
				$whereclause_category = " AND categoryId = " . $_PARAM["categorias"];
			else:
				$whereclause_category = "";
			endif;	
			if(@$_PARAM["puntos_desde"] AND @$_PARAM["puntos_hasta"] ):
				$puntos_clause = "AND points BETWEEN " . $_PARAM["puntos_desde"] . " AND ". $_PARAM["puntos_hasta"];  
			elseif(@$_PARAM["puntos_desde"]):
				$puntos_clause = "AND points >= " . $_PARAM["puntos_desde"];  					
			elseif(@$_PARAM["puntos_hasta"]):
				$puntos_clause = "AND points <= " . $_PARAM["puntos_hasta"];  					
			else:
				$puntos_clause = "";
			endif;	


			$conn = new Conexion();

			$sql = $conn->prepare('SELECT P.*, PC.name as categoria from products P INNER JOIN productscategory PC ON P.categoryId = PC.id WHERE P.active = 1 and P.stock > 0 ' . $whereclause_category . $puntos_clause . $whereclause_name );
			$sql->execute();
			$datos_carga = $sql->fetchAll();
			return($datos_carga);

		}

		function get_products_backend(){


			$conn = new Conexion();

			$sql = $conn->prepare('SELECT P.*, PC.name as categoria from products P INNER JOIN productscategory PC ON P.categoryId = PC.id');
			$sql->execute();
			$datos_carga = $sql->fetchAll();
			return($datos_carga);

		}

		function products_rel($_id,$categoryId){
			$conn = new Conexion();

			$sql = $conn->prepare('select * from products WHERE active = 1 and id != :ID and categoryId = :CATEGORYID LIMIT 3 ');
			$sql->execute(array('ID' => $_id, 'CATEGORYID' => $categoryId));
			$datos_carga = $sql->fetchAll();
			return($datos_carga);			

		}

		function buscarProductsAjax($palabra){

		//	$palabra = mysql_real_escape_string(htmlspecialchars(stripslashes(trim($palabra))));

			$conn = new Conexion();

			$sql = $conn->prepare("SELECT * from products where active = 1 and name like '%$palabra%'   GROUP BY name" );
			$sql->execute();
			$resultado = $sql->fetchAll();
			$productos = array();

			if($resultado):
				foreach ($resultado as $row) {
					$productos[] = array("value" => $row['name'],
								 "name" => $row['name']
										);
				}
				return($productos);
			else:
				return(false);
			
			endif;	
			$conn = null;
			$sql = null;

		}


		function confirm_canje($product_id, $product_points, $user_id){
		//id, idUser, idProduct, points, date, active
			$conn = new Conexion();
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;

			// COMPROBAR DUPLICADO
			$sql = $conn->prepare(" SELECT * FROM exchanges where idProduct = :PRODUCTID and idUser = :USERID AND points = :POINTS and Date_format(date,'%Y-%m-%d') = curdate() order by id desc limit 1");
			$sql->execute(array('USERID' => $user_id, 'PRODUCTID' => $product_id, 'POINTS' => $product_points));			
			$resultado = $sql->fetch(PDO::FETCH_ASSOC);

			if($resultado):	
				$fecha1 = new DateTime($hora_actual);
				$fecha2 = new DateTime($resultado["date"]);
				$fecha = $fecha1->diff($fecha2);
	//			printf('%d años, %d meses, %d días, %d horas, %d minutos, %d segundos', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i, $fecha->s);

				if( $fecha->h == 0 and $fecha->i == 0 ): 
				     echo '<script type="text/javascript">window.location.assign("../home.html");</script>';     
				 	return "";
				 endif; 
				// COMPROBAR DUPLICADO

			endif;


			$sql = $conn->prepare("INSERT INTO exchanges values (NULL, :USERID, :PRODUCTID, :POINTS, '$hora_actual', 1, 1, NULL )");
			$sql->execute(array('USERID' => $user_id, 'PRODUCTID' => $product_id, 'POINTS' => $product_points));			
			$lastId = $conn->lastInsertId();

			if($lastId):
				Product::discount_point($user_id, $product_points);
				Product::discount_stock_product($product_id);
				Notification::new_notification("C", $lastId, $user_id);	
			endif;	

		}

		function get_canje($_id){
			$conn = new Conexion();
			
			$sql = $conn->prepare("SELECT E.*, P.name from exchanges E INNER JOIN products P ON P.id = E.idProduct where E.id = :ID");
			$sql->execute(array('ID' => $_id));
			
			return ($sql->fetch(PDO::FETCH_ASSOC));
			$conn = null;
			$sql=null;

		}
		
		function get_canjes_enproceso($tipo=0){
			if(!$tipo) $tipo = "DG";

			$conn = new Conexion();
			$sql = $conn->prepare("SELECT E.*, P.name, P.code,PC.name as categoria, U.name as usuario, U.area, U.subarea, D.receptor, D.direccion, D.localidad, D.observaciones, D.cp, P.price, U.companyCode, U.cecoFacturacion, P.tipo, U.legajo, U.ceco from exchanges E INNER JOIN products P ON P.id = E.idProduct INNER JOIN productscategory PC ON P.categoryId = PC.id INNER JOIN users U ON E.idUser = U.id LEFT JOIN delivery D on U.entrega = D.id where E.status = 1 and P.tipo = :TIPO  order by area, E.date");
			$sql->execute(array('TIPO' => $tipo));
			
			return ($sql->fetchAll());
			$conn = null;
			$sql=null;

		}

		function get_canjes($subarea){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT E.*, P.name, P.code,PC.name as categoria, U.name as usuario, U.area, U.subarea from exchanges E INNER JOIN products P ON P.id = E.idProduct INNER JOIN productscategory PC ON P.categoryId = PC.id INNER JOIN users U ON E.idUser = U.id where E.status = 1 and U.subarea = :SUBAREA  order by area, E.date");
			$sql->execute(array('SUBAREA' => $subarea));
			
			return ($sql->fetchAll());
			$conn = null;
			$sql=null;

		}


		function mis_canjes($_user_id){
			$conn = new Conexion();
			
			$sql = $conn->prepare("SELECT E.*, P.name from exchanges E INNER JOIN products P ON P.id = E.idProduct where E.idUser = :ID");
			$sql->execute(array('ID' => $_user_id));
			
			return ($sql->fetchAll());

		}


		function discount_stock_product($product_id){
/*				$user_id = Reward::test_input($user_id);
				$points = Reward::test_input($points);
*/
				$conn = new Conexion();

				$sql = $conn->prepare('UPDATE products set stock = stock - 1   where id= :ID');
				$sql->execute(array('ID' => $product_id));

				$conn = null;
				$sql = null;
		}


		function discount_point($user_id, $points){

			$conn = new Conexion();

			$sql = $conn->prepare('UPDATE users_points set points = points - :points   where userId= :ID');
			$sql->execute(array('ID' => $user_id, 'points' => $points));

			$conn = null;
			$sql = null;
		}

		function get_category_name($_id){

			$conn = new Conexion();

			$sql = $conn->prepare("SELECT PC.name from products P INNER JOIN productscategory PC ON PC.id = P.categoryId where P.id = :ID");
			$sql->execute(array('ID' => $_id));

			return $sql->fetchColumn();		

			$conn = null;
			$sql = null;

		}

		function procesar_canjes($canjes){
			//ALTA PROCESO

			$conn = new Conexion();
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$_hora= date ("H:i:s");
			$_fecha= date ("Y-m-d");
			$hora_actual = $_fecha . " " . $_hora;

			$sql = $conn->prepare("INSERT INTO exchanges_process values (NULL, '$hora_actual', 1 )");
			$sql->execute();			
			$lastId_process = $conn->lastInsertId();			
			//ALTA PROCESO

			//ALTA DELIVERY
			$sql = $conn->prepare("SELECT subarea FROM `exchanges` E INNER JOIN users U ON U.id = E.idUser where E.id IN ($canjes) GROUP BY subarea");
			$sql->execute();			
			$resultado = $sql->fetchAll();
			foreach ($resultado as $res):  
				$sql = $conn->prepare("INSERT INTO exchanges_process_delivery values (NULL, :SUBAREA, :PROCESS , '$hora_actual', 1 )");
				$sql->execute(array('SUBAREA' => $res["subarea"], 'PROCESS' => $lastId_process));			
				$lastId_delivery = $conn->lastInsertId();			
				// ALTA RELACION CANJE CON ENVIO
				$sql_rel = $conn->prepare("SELECT E.id, E.statusUrbano FROM `exchanges` E INNER JOIN users U ON U.id = E.idUser where E.id IN ($canjes) AND subarea = :SUBAREA");
				$sql_rel->execute(array('SUBAREA' => $res["subarea"]));			
				$resultado_rel = $sql_rel->fetchAll();				
				foreach ($resultado_rel as $res_rel):
					$sql = $conn->prepare("INSERT INTO exchanges_rel_delivery values (:EXCHANGE, :DELIVERY)");
					$sql->execute(array('EXCHANGE' => $res_rel["id"], 'DELIVERY' => $lastId_delivery));				
					//AGREGO HISTORIAL DE CANJES
					$sql = $conn->prepare("INSERT INTO exchanges_historial values (null, :EXCHANGE, 2, :STATUSURBANO, NOW(), 1)");
					$sql->execute(array('EXCHANGE' => $res_rel["id"], 'STATUSURBANO' => $res_rel["statusUrbano"] ));									
					//AGREGO HISTORIAL DE CANJES

				endforeach;				
				// ALTA RELACION CANJE CON ENVIO

			endforeach;	
			
			//ALTA DELIVERY
		//		echo "UPDATE exchanges E set status = 2 where E.id IN ($canjes)";die;
			//cambios de estado exchanges
				$sql = $conn->prepare("UPDATE exchanges E set status = 2 where E.id IN ($canjes)");
				$sql->execute();

				$conn = null;
				$sql = null;			
			

				return($lastId_process);

		}

		function get_process_delivery($lastId_process){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT * FROM exchanges_process_delivery where processId = :PROCESSID ");
			$sql->execute(array('PROCESSID' => $lastId_process));			
			
			return ($sql->fetchAll());
		}

		function canjes_x_envio($envio_id){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT E.id as canjeId, P.name as producto, P.code, U.name as usuario, U.legajo, D.direccion, D.observaciones, D.localidad, D.cp, D.receptor, U.cecoFacturacion, U.ceco, U.legajo, U.companyCode, P.price, E.date, E.statusUrbano, P.tipo FROM `exchanges_rel_delivery` ERD INNER JOIN exchanges E ON ERD.idExchange = E.id INNER JOIN products P on P.id = E.idProduct INNER join users U ON E.idUser = U.id LEFT JOIN delivery D on U.entrega = D.id WHERE idDelivery = :ENVIO");
			$sql->execute(array('ENVIO' => $envio_id));			
			
			return ($sql->fetchAll());

		}

		function get_exchange_process(){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT * from exchanges_process order by id DESC");
			$sql->execute();			
			
			return ($sql->fetchAll());

		}


		function get_exchange_realizados(){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT E.*, P.name, P.code,PC.name as categoria, U.name as usuario, U.area, U.subarea, D.receptor, D.direccion, D.localidad, D.observaciones, D.cp, P.price, U.companyCode, U.cecoFacturacion, U.ceco, U.legajo FROM exchanges E INNER JOIN products P ON P.id = E.idProduct INNER JOIN productscategory PC ON P.categoryId = PC.id INNER JOIN users U ON E.idUser = U.id LEFT join delivery D on U.entrega = D.id where E.status = 4 OR E.status = 3 order by E.id desc");
			$sql->execute();			
			
			return ($sql->fetchAll());

		}


		function get_canjes_x_proceso($id_delivery){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT E.*, P.name, P.code,PC.name as categoria, U.name as usuario, U.area, U.subarea, D.receptor, D.direccion, D.localidad, D.observaciones, D.cp, P.price, U.companyCode, U.cecoFacturacion, U.ceco, U.legajo from exchanges E INNER JOIN products P ON P.id = E.idProduct INNER JOIN productscategory PC ON P.categoryId = PC.id INNER JOIN users U ON E.idUser = U.id INNER JOIN exchanges_rel_delivery as ERD ON ERD.idExchange = E.id LEFT join delivery D on U.entrega = D.id where E.status = 2 and  ERD.idDelivery = :DELIVERY order by area, E.date");
			$sql->execute(array('DELIVERY' => $id_delivery));
			
			return ($sql->fetchAll());
		}

		function change_status($status, $status_urbano, $_id){
			//echo "aca entro";die;
			$conn = new Conexion();
			$sql = $conn->prepare("UPDATE exchanges set status = :STATUS, statusUrbano = :STATUSURBANO  where id = :ID");
			$sql->execute(array('STATUS' => $status, 'STATUSURBANO' => $status_urbano, 'ID' => $_id ));

			$sql = $conn->prepare("INSERT INTO exchanges_historial values (null, :ID, :STATUS, :STATUSURBANO, NOW(), 1)");
			$sql->execute(array('STATUS' => $status, 'STATUSURBANO' => $status_urbano, 'ID' => $_id));					

		}

		function canje_cambio($_id, $tipo){

			if($tipo == "DV"):
				$status = 6;
			elseif($tipo == "CA"):
				$status = 7;
			endif;	

			$conn = new Conexion();
			$sql = $conn->prepare("UPDATE exchanges set status = :STATUS, statusUrbano = :STATUSURBANO  where id = :ID");
			$sql->execute(array('STATUS' => 1, 'STATUSURBANO' => $tipo, 'ID' => $_id ));

			$sql = $conn->prepare("INSERT INTO exchanges_historial values (null, :ID, :STATUS, :STATUSURBANO, NOW(), 1)");
			$sql->execute(array('STATUS' => $status, 'STATUSURBANO' => $tipo, 'ID' => $_id));								

		}

		function product_visitas($_id){
			$conn = new Conexion();
			$sql = $conn->prepare("UPDATE products set visitas = visitas + 1 where id = :PRODUCTO");
			$sql->execute(array('PRODUCTO' => $_id));
		}

		function get_products_counts(){
			$conn = new Conexion();
			$sql = $conn->prepare("SELECT P.*, count(e.id) as canjes, PC.name as categoria FROM `products` P LEFT JOIN exchanges e on e.idProduct = P.id inner join productscategory as PC ON PC.id = P.categoryId GROUP by P.id");
			$sql->execute();
			$resultado = $sql->fetchAll();

			$sql=null;
			$conn=null;

			return $resultado;

		}

		 /*---GETTERS--------------------------------------------------------------*/ 
		function get_id() { return($this->id); }
		function get_name() { return($this->name); }
		function get_desc() { return($this->desc); }
		function get_code() { return($this->code); } 
		function get_categoryId() { return($this->categoryId); }
		function get_points() { return($this->points); } 
		function get_stock() { return($this->stock); } 
		function get_terms() { return($this->terms); } 
		function get_active() { return($this->active); } 
		function get_date() { return($this->date); } 
		function get_brand() { return($this->brand); } 
		function get_prince() { return($this->price); } 
		function get_model() { return($this->model); } 
		function get_visitas() { return($this->visitas); } 


		/*------------------------------------------------------------------------*/ 
		/*---SETTERS--------------------------------------------------------------*/ 
		function set_id($_id) { $this->id = $_id; } 
		function set_name($_name) { $this->name = $_name; } 
		function set_desc($_desc) { $this->desc = $_desc; } 
		function set_code($_code) { $this->code = $_code; } 
		function set_categoryId($_categoryId) { $this->categoryId = $_categoryId; } 
		function set_points($_points) { $this->points = $_points; } 
		function set_stock($_stock) { $this->stock = $_stock; } 
		function set_terms($_terms) { $this->terms = $_terms; } 
		function set_active($_active) { $this->active = $_active; } 
		function set_date($_date) { $this->date = $_date; }
		function set_brand($_brand) { $this->brand = $_brand; }
		function set_price($_price) { $this->price = $_price; }
		function set_model($_model) { $this->model = $_model; }
		function set_visitas($_visitas) { $this->visitas = $_visitas; }

		 /*------------------------------------------------------------------------*/ 
	}
?>