<?php

class Template
{
	function draw_header($acceso=0)
	{   
//   header('X-Frame-Options: SAMEORIGIN'); // FF 3.6.9+ Chrome 4.1+ IE 8+ Safari 4+ Opera 10.5+

   date_default_timezone_set('America/Argentina/Buenos_Aires');
   $_hora= date ("H:i:s");
    $_usuario = unserialize($_SESSION["user"]);
    $notificaciones3 = Notification::get_notifications($_usuario->id, 3);  

       ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--          <meta name="viewport" content="width=device-width, initial-scale=1">-->
          <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
            <link rel="shortcut icon" type="image/png" href="<?php echo IMGS?>favicon.png"/>
          	<title>Rec</title>
            <link href="<?php echo CSS?>font-awesome.min.css" rel="stylesheet"/>
            <link href="<?php echo BOOTSTRAP_CSS?>bootstrap.min.css" rel="stylesheet"/>

            <link href="<?php echo CSS?>rec.css" rel="stylesheet"/>
            <link href="<?php echo CSS?>loading_img.css" rel="stylesheet"/>

            <link href="<?php echo CSS?>jquery-ui.min.css" rel="stylesheet"/>
            <link href="<?php echo CSS?>menu_adaptable.css" rel="stylesheet"/>

                
            <script language="JavaScript" src="<?php echo JS?>jquery-3.1.0.min.js"></script>
            <script language="JavaScript" src="<?php echo JS?>jquery.validate.js"></script>
            

            <script language="JavaScript" src="<?php echo BOOTSTRAP_JS?>bootstrap.min.js"></script>
            <script language="JavaScript" src="<?php echo JS?>menu_adaptable.js"></script>

            <script type="text/javascript" src="<?php echo JS?>jquery.openCarousel.js"></script> 
              <link rel="stylesheet" href="<?php echo CSS?>clndr.css" type="text/css" />
            <script src= "<?php echo JS?>moment-2.2.1.js" type="text/javascript"></script>
            <script src="<?php echo JS?>clndr.js" type="text/javascript"></script>
            <script src="<?php echo JS?>site.js" type="text/javascript"></script>
            <script src="<?php echo JS?>jquery-ui.min.js" type="text/javascript"></script>
            <script src="<?php echo JS?>jquery-ui.triggeredAutocomplete.js" type="text/javascript"></script>



            <script type="text/javascript">
              
              moment.lang('es');

            </script>

            <script type="text/javascript">
            $(document).ready(function(){

                  $('#notificaciones_click').click(function(){
                  
                  $('.menu_usuario').hide();

                  var parent = $(this).parent().attr('id');
                  if ($('#'+parent+' .menu_notificaciones').is (':hidden'))
                      $('#'+parent+' .menu_notificaciones').show();
                  else
                      $('#'+parent+' .menu_notificaciones').hide();
                  return false;
                  }); 


                  $('#usuario_click').click(function(){
                  
                  $('.menu_notificaciones').hide();
                  var parent = $(this).parent().attr('id');
                  if ($('#'+parent+' .menu_usuario').is (':hidden'))
                      $('#'+parent+' .menu_usuario').show();
                  else
                      $('#'+parent+' .menu_usuario').hide();
                  return false;
                  }); 

                  $('body,html').click(function(){
                       $('.menu_notificaciones').hide();
                       $('.menu_usuario').hide();

                  });
                  

            });

            function nobackbutton(){
               window.location.hash="no-back-button";
               window.location.hash="Again-No-back-button" //chrome
               window.onhashchange=function(){window.location.hash="no-back-button";}
            }            
            </script>


        </head>

        <body onDragOver="return false;" onload="nobackbutton();">
        <?php include_once("../analyticstracking.php"); ?>

        <?php if($acceso == 0):?>

            <!-- menu adaptable -->  
              <div class="header" >  
              <div class="menu_bar" >
                <div class="col-xs-6" style="padding-top: 5px">
                   <a href="<?php echo HOME?>home.html"><img src="<?php echo IMGS?>logo.png" ></a>   
                </div>
                  <div class="col-xs-4" style="padding-top: 7px">
                  <a id="ruedita"><img src="<?php echo IMGS?>configuracion.png"></a>                

                  <?php if( $notificaciones = Notification::get_counts_notifications($_usuario->id)): ?>                  
                   <a href="<?php echo HOME?>notificaciones.html" style="color:white; text-decoration: none;cursor: pointer" ><img src="<?php echo IMGS?>alertas.png">
                    <div style="position: absolute; top:0px; left:60px; background-image: url(<?php echo IMGS?>alerta.png); width: 20px; height: 20px; padding-top: 0px; padding-left: 6px"> <?php echo $notificaciones;?></div></a>
                  <?php else:?>
                    <a href="<?php echo HOME?>notificaciones.html"><img src="<?php echo IMGS?>alertas.png"></a>            
                  <?php endif;?> 
                </div>
                  <div class="col-xs-2" id="menu_bar">
                  <a href="#" class="bt-menu"><span id="span_menu" style="color: white; font-weight: bold;font-size: 32px;">☰</span></a>
                </div>
                <div class="col-xs-11" style="border: 1px solid; padding: 10px; margin: 10px; color: white; ">
                  <div class="col-xs-6">
                    Mis Puntos <font color="#ffe100"><?php echo User::get_points($_usuario->id,1);?></font>
                  </div>
                  <div class="col-xs-6">
                    A reconocer <font color="#ffe100"><?php echo User::get_points($_usuario->id,2);?></font>
                  </div>
                </div>

              </div>

              <nav class="menu_adaptable" >
                <ul>
                    <li ><a href="<?php echo HOME?>home.html">Muro</a></li>
                    <li ><a href="<?php echo HOME?>mimuro.html">Mi Perfil</a></li>
                    <li ><a href="<?php echo HOME?>RRHH.html">Novedades</a></li>
                    <li ><a href="<?php echo HOME?>comportamientos.html">7 Comportamientos</a></li>
                    <li ><a href="<?php echo HOME?>catalogo.html">Canjea tus puntos</a></li>                    
                    <li ><a href="<?php echo HOME?>tendencias.html">Tendencias</a></li>
                    <li ><a href="<?php echo HOME?>contacto.html">Contacto</a></li>


                </ul>
              </nav>
              <nav class="menu_adaptable2" >
                <ul>
                    <li ><a href="<?php echo HOME?>miperfil.html"> Mis Datos </a></li>
                    <li ><a href="<?php echo HOME?>mis_canjes.html">Mis Canjes</a></li>
                    <li ><a href="<?php echo HOME?>cambiar_clave.html">Cambiar contraseña</a></li>                        
                    <li ><a href="<?php echo HOME?>">Salir</a></li>

                </ul>
              </nav>

              </div>
            <!-- menu adaptable -->  

          <div class="row" id="cabecera" >

            <div class="container_cabecera">
              <div class="col-xs-3" ><a href="<?php echo HOME?>home.html"><img src="<?php echo IMGS?>logo.png"></a></div>
              <div class="col-xs-3">
                <?php include_once '../view/buscador.php'; ?>
              </div>
              <div class="col-xs-4 text-right" id="panel" style="padding-left:0px;margin-left:0px">
                  <div class="col-xs-5" style="padding-left:0px;">
                    <img src="<?php echo IMGS ?>mis-puntos.png">
                     <span >Mis Puntos</span>
                    <span style="color:#ffe100; font-size:16px"><?php echo User::get_points($_usuario->id,1);?></span>
                  </div>
                  <div class="col-xs-7" style="padding-left:0px;">
                    <img src="<?php echo IMGS?>puntos-reconocimiento.png">
                    <span>Puntos para reconocer</span>
                    <span style="color:#ffe100; font-size:16px;"><?php echo User::get_points($_usuario->id,2);?></span>
                  </div>


              </div>
              <div class="col-xs-2 text-center" id="panel" style="padding-left: 70px">

                  <?php if( $notificaciones = Notification::get_counts_notifications($_usuario->id)): ?>                  
                   <a id="notificaciones_click" style="color:white; text-decoration: none;cursor: pointer" ><img src="<?php echo IMGS?>alertas.png">
                    <div style="position: absolute; top:2px; left:95px; background-image: url(<?php echo IMGS?>alerta.png); width: 20px; height: 20px; padding-top: 3px"> <?php echo $notificaciones;?></div></a>
                  <?php else:?>
                    <a href="<?php echo HOME?>notificaciones.html"><img src="<?php echo IMGS?>alertas.png"></a>            
                  <?php endif;?>                  
                  <!-- href="< ?php e cho HOME?>notificaciones.html" -->
                  <img id="usuario_click" src="<?php echo IMGS?>configuracion.png">
                  <?php if($_usuario->img_perfil):?>  
                  <img src="<?php echo IMGS_PERFIL . "min_". $_usuario->img_perfil;  ?>">                    
                  <?php else:?>
                  <img src="<?php echo IMGS?>foto-perfil.png">
                  <?php endif;?>


                    <div class="menu_notificaciones">
                        <li style="background:#eaf5fB; height: 30px; padding: 7px; color:black; font-weight: bold ">Mis nofiticaciones</li>
                        <?php foreach($notificaciones3 as $notificacion):
                          if($notificacion["type"] == "R"):
                          $reward = Reward::get_reward_id($notificacion["typeId"]);
                        ?>  

                          <li><a href="<?php echo HOME?>buscador/<?php echo $reward["userId"]?>/"><?php echo $reward["usuario"]?></a> <a style="color:#B0B0B0" href="<?php echo HOME?>publicacion/<?php echo $reward["wallId"]?>/">te reconocío</a></li>
                        <?php 
                          elseif($notificacion["type"] == "@"):
                            $comment = Wall::get_wall_by_typeId($notificacion["typeId"]);
                        ?>
                          <li><a href="<?php echo HOME?>buscador/<?php echo $comment["idUser"]?>/"><?php echo $comment["name"]?></a> <a style="color:#B0B0B0" href="<?php echo HOME?>publicacion/<?php echo $comment["id"]?>/">Te mensionó en la publicación </a> </li>
                        <?php 
                          elseif($notificacion["type"] == "CO"):
                            $comment = Wall::get_coments_id($notificacion["typeId"]);
                        ?>
                          <li><a href="<?php echo HOME?>buscador/<?php echo $comment["idUser"]?>/"><?php echo $comment["name"]?></a> <a style="color:#B0B0B0" href="<?php echo HOME?>publicacion/<?php echo $comment["idWall"]?>/">Comentó tu publicación </a> </li>                        
                        <?php 
                          elseif($notificacion["type"] == "C"):
                         //   $comment = Wall::get_coments_id($notificacion["typeId"]);
                        ?>
                          <li><a style="color:#B0B0B0" href="<?php echo HOME?>mis_canjes.html">Canjeaste un producto!!! </a> </li>

                        <?php 
                          elseif($notificacion["type"] == "FP"):
                            $comment = Wall::get_coments_id($notificacion["typeId"]);
                        ?>
                          <li><a style="color:#B0B0B0" href="<?php echo HOME?>notificaciones.html">Recibiste 2000 puntos por consigna cumplida.</a> </li>

                        <?php 
                        endif;
                        endforeach;?>  
                        <li  style=" padding-top: 10px">
                        <div id="strike">
                            <span><a href="<?php echo HOME?>notificaciones.html"> ver todo</a></span>
                        </div>
                        </li>


                    </div>

                    <div class="menu_usuario">
                        <li style="background:#eaf5fB; height: 30px; padding: 7px; color:black; font-weight: bold "><?php echo $_usuario->name?></li>                    
                        <li ><a href="<?php echo HOME?>miperfil.html"> Mis Datos </a></li>
                        <li ><a href="<?php echo HOME?>mis_canjes.html">Mis Canjes</a></li>
                        <li ><a href="<?php echo HOME?>cambiar_clave.html">Cambiar contraseña</a></li>                        
                        <li ><a href="<?php echo HOME?>">Salir</a></li>
                        

                    </div>

              </div>
            </div>  

            </div><!--endcabecera-->
          
        <div class="container">
          
<?php
    else:

    endif;  
  }

	function draw_footer()
	{ 

	?>


        </div> <!-- /container -->
        <footer>

        </footer>

        </div><!--container-master-->
        </body>

    </html>

	<?php
	}
}
?>