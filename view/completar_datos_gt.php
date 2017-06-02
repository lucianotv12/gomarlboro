
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Go Marlboro</title>

    <link href="<?php echo CSS?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS?>style.css" rel="stylesheet">
    <link href="<?php echo CSS?>style-GT.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo JS?>bootstrap.min.js"></script>
    <script language="JavaScript" src="<?php echo JS?>jquery-3.1.0.min.js"></script>
    <script language="JavaScript" src="<?php echo JS?>jquery.validate.js"></script>      
    <script src="<?php echo JS?>jquery.maskedinput.js" type="text/javascript" ></script>    
    <script type="text/javascript">
        $(document).ready(function(){
          $('#fecha').mask('99/99/9999');

                $("#datos").validate({ 
                    rules: {             
                        nombre: { required: true, minlength: 3},
                        celular:{required:true, number: true},
                        email:{email:true}

                    },messages:{
                      nombre: "Campo Requerido",                     

                    }

                });

        });


    </script>    
  </head>
  <body>
    <?php include_once("../analyticstracking.php") ?>

    <section class="background-image login-background">
      <nav id="menu" class="navbar navbar-default hidden-desktop">
        <div class="container full-width-mobile">
          <!-- MOBILE MENU  -->
          <div class="hidden-desktop bold uppercase">
            <div class="navbar-header">
              <a class="navbar-brand">
                <img src="<?php echo IMGS?>gt/go-marlboro-title.png">
              </a>
            </div>
          </div>
          <!-- END MOBILE MENU  -->
        </div>
      </nav>
      <form class="" name="datos" id="datos" method="post" action="<?php echo HOME?>cambiar_datos_gt.html">      
      <div class="container">
        <div class="col-md-6">
          <div class="perfil-container">
            <div class="perfil-box">
              <img src="<?php echo IMGS?>gt/user.png">
              <input type="radio" name="tipo_usuario" value="Dueño" checked="checked">
              <button type="button" class="btn btn-grey">Dueño</button>
            </div>
            <div class="perfil-box">
              <img src="<?php echo IMGS?>gt/user.png">
              <input type="radio" name="tipo_usuario" value="empleado">

              <button type="button" class="btn btn-grey">Empleado</button>
            </div>
          </div>
        </div>
        <div class="col-md-6 " >
            <div class="login-form sign-up" >
            <div class="input-group">
              <input type="text" class="form-control" name="nombre" placeholder="NOMBRE_">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </div>
            <div class="input-group input-separation">
              <input type="text" class="form-control" id="fecha" name="fecha" placeholder="FECHA DE NACIMIENTO_">
            </div>
            <div class="input-group input-separation">
              <input type="text" class="form-control" name="celular" placeholder="CELULAR_">
            </div>
            <div class="input-group input-separation-extend">
              <input type="email" class="form-control" name="email" placeholder="MAIL_">
            </div>
            <div class="button-container">
              <button type="submit" name="guardar" id="guardar" class="btn btn-grey fleft btn-perfil">Guardar Cambios</button>
              <button type="submit" name="mas" id="mas" class="btn btn-grey fright btn-perfil">Cargar Más</button>
            </div>
          </div>
        </div>
      </div>
      </form>
    </section>
  </body>
</html>