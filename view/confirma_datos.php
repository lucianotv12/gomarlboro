
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Go marlboro</title>

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
          <form class="login-form sign-up" method="post" action="usuario_confirmado.html">
          <input type="hidden" name="user_id" value="<?php echo $datos['id']?>">
            <div class="input-group">

              <p class="form-control"><?php echo  htmlspecialchars_decode($datos["razon_social"])?></p>
            </div>
            <div class="input-group input-separation">

              <p class="form-control"><?php echo htmlspecialchars_decode($datos["calle"]) . " " . $datos["numero"] ?></p>
            </div>
            <div class="input-group input-separation">
              <p class="form-control"><?php echo $datos["localidad"]?></p>
            </div>
            <div class="input-group input-separation-extend">

              <p class="form-control"><?php echo $datos["provincia"]?></p>
            </div>
            <div class="button-container">
              <button type="button" class="btn btn-grey fleft" onclick="javascript:history.back(1)">Cancelar</button>
              <button type="submit" class="btn btn-grey fright">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>