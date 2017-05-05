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
  </head>
  <body>
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
          <form class="login-form sign-up">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="NOMBRE_">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </div>
            <div class="input-group input-separation optional">
              <input type="text" class="form-control" placeholder="FECHA DE NACIMIENTO_">
            </div>
            <div class="input-group input-separation optional2">
              <input type="text" class="form-control" placeholder="CELULAR_">
            </div>
            <div class="input-group input-separation-extend optional3">
              <input type="text" class="form-control" placeholder="MAIL_">
            </div>
            <div class="button-container">
              <button type="button" class="btn btn-grey fleft clear-mobile">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>