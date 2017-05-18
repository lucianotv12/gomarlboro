<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Cambio clave</title>

    <link href="<?php echo CSS?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS?>style.css" rel="stylesheet">
    <link href="<?php echo CSS?>style-GT.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script language="JavaScript" src="<?php echo JS?>jquery-3.1.0.min.js"></script>
    <script language="JavaScript" src="<?php echo JS?>jquery.validate.js"></script>
    <script src="<?php echo JS?>bootstrap.min.js"></script>

    
<script type="text/javascript">
    $(document).ready(function(){
      $.validator.addMethod("pwcheck", function(value) {
         return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
             && /[a-z]/.test(value) // has a lowercase letter
             && /\d/.test(value) // has a digit
      });

            $("#cambiar_clave").validate({ 
                rules: {             
                    clave_nueva: { required: true, minlength: 8, pwcheck: true},
                    clave_nueva1: { required: true, minlength: 8, pwcheck: true},
                },messages:{
                  clave: "Campo Requerido",                     
                clave_nueva: {
                    minlength: "Longitud minima 8 digitos",
                    pwcheck: "Debe tener letras y numeros"
                },
                clave_nueva1: {
                    minlength: "Longitud minima 8 digitos",
                    pwcheck: "Debe tener letras y numeros"
                }

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
      <div class="container">
        <div class="col-md-6"></div>
        <div class="col-md-6">
          <form class="login-form sign-up" id="cambiar_clave" name="cambiar_clave" method="post" action="cambiar_clave.html">
            <div class="input-group">
              <input type="password" id="clave_nueva" name="clave_nueva" class="form-control" placeholder="- NUEVA CONTRASEÑA">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </div>
            <div class="input-group input-separation">
              <input type="password" id="clave_nueva1" name="clave_nueva1" class="form-control" placeholder="- CONFIRMAR CONTRASEÑA">
              <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
            </div>
            <div class="button-container">
              <button type="submit" class="btn btn-grey">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>