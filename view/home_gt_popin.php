
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
    <link href="<?php echo CSS?>style-KA.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo JS?>bootstrap.min.js"></script>
  </head>
  <body>
    <section class="background-image home-background popin">
      <nav id="menu" class="navbar navbar-default">
        <div class="container full-width-mobile">
          <!-- DESKTOP MENU -->
          <div class="menu-container bold hidden-mobile">
            <img src="<?php echo IMGS?>gt/menu.png">
            <button type="button" class="btn-arrow dropdown-toggle down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="chances-container">
              <p>Chances Acumuladas <?php echo $_usuario->puntos?></p>
            </div>
            <ul class="dropdown-menu">
              <li><a href="#">Premios</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Bases y condiciones</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Web marlboro</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Video tutorial</a></li>
            </ul>
          </div>
          <!-- END DESKTOP MENU -->
        
          <!-- MOBILE MENU  -->
          <div class="hidden-desktop bold uppercase">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand">
                <img src="<?php echo IMGS?>gt/go-marlboro-title.png">
              </a>
            </div>
            <div class="chances-acumuladas">
              <p>Chances amuculadas <?php echo $_usuario->puntos?></p>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="#">Bases y condiciones</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Premios</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Web marlboro</a></li>
                <li role="separator" class="divider"></li>
                <li class="salir"><a href="#">Salir</a></li>
              </ul>
            </div>
          </div>
          <!-- END MOBILE MENU  -->
        </div>  
      </nav>

      <!-- Modal -->
      <div class="container popin">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <form name="popin" method="post" action="<?php echo HOME?>">
            <button id="myModalClose" type="submit" class="close" data-dismiss="modal">
              <img src="<?php echo IMGS?>gt/close.png">
            </button>
           </form> 
            <div class="modal-body">
              <p class="red uppercase bold no-sep">Ya sumaste tus primeras</p>
              <p class="red uppercase bigger bold">10 chances</p>
              <div class="sub-content">
                <p>Por solo haberte registrado</p>
                <p class="bold">obtenés 10 chances extras en los sorteos mensuales.</p>
                <p>Más facil imposible</p>
                <p class="bold">¡Superá tus límites y segui sumando!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>