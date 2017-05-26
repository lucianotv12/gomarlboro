
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
    <section class="background-image home-background home-modal2-background">
      <nav id="menu" class="navbar navbar-default">
        <div class="container full-width-mobile">
          <!-- DESKTOP MENU -->
          <div class="menu-container bold hidden-mobile">
            <img src="<?php echo IMGS?>gt/menu.png">
            <button type="button" class="btn-arrow dropdown-toggle down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="chances-container">
              <p>Chances Acumuladas 10</p>
            </div>
            <ul class="dropdown-menu">
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo HOME?>premios_GT.html">Premios</a></li>
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
              <p>Chances amuculadas 1234</p>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="#">Bases y condiciones</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="./premios.html">Premios</a></li>
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
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content mlb-modal box-2">
          <div class="modal-body">
            <img src="<?php echo IMGS?>gt/mlb-core.png">
          </div>
          <a class="back-home" href="./home.html">
            <img src="<?php echo IMGS?>ka/arrow-left.png">
          </a>
        </div>
      </div>

      <div class="container hidden-mobile">
        <div class="bottom-text bold">
          <p>¡Aprovechá todas las oportunidades de sumar y ganá con marlboro!</p>
          <p>¡No dejes que nada te frene!</p>
        </div>
      </div>

    </section>
  </body>
</html>