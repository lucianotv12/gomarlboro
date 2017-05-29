
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Go Marlboro</title>

    <link href="<?php echo CSS?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo CSS?>style.css" rel="stylesheet">
    <link href="<?php echo CSS?>style-KA.css" rel="stylesheet">
    <link href="<?php echo CSS?>style-GT.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo JS?>bootstrap.min.js"></script>
  </head>
  <body>

  <?php if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"):?>
    <section class="background-image premios-gt-background">

  <?php else:?> 
    <section class="background-image premios-gt-background_chances">
    
  <?php endif;?>    
      <nav id="menu" class="navbar navbar-default">
        <div class="container full-width-mobile">
          <!-- DESKTOP MENU -->
          <div class="menu-container bold hidden-mobile">
            <a href="<?php echo HOME?>home.html"><img src="<?php echo IMGS?>gt/menu.png"></a>
            <button type="button" class="btn-arrow dropdown-toggle down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <ul class="dropdown-menu">
              <li role="separator" class="divider"></li>
              <li><a href="#">Premios</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Bases y condiciones</a></li>
              <li role="separator" class="divider"></li>
              <li><a target="_blank" href="https://www.marlboro.com.ar">Web marlboro</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo HOME?>video_gt.html">Video tutorial</a></li>
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
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="#">Bases y condiciones</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Premios</a></li>
                <li role="separator" class="divider"></li>
                <li><a   href="https://www.marlboro.com.ar">Web marlboro</a></li>
                <li role="separator" class="divider"></li>
                <li class="salir"><a href="#">Salir</a></li>
              </ul>
            </div>
          </div>
          <!-- END MOBILE MENU  -->
        </div>
      </nav>
      <div class="container separation-nav hidden-desktop premios premios-gt">
        <div class="home-text">
          <img src="<?php echo IMGS?>mobile/supera-tus.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/moto-plegable.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/bici-plegable.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/avion.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/play4.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/tv-40.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/tv-32.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/moto-x.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/camara.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/tablet.png">
        </div>
        <div class="premio-row">
          <img src="<?php echo IMGS?>mobile/gifts/panasonic.png">
        </div>
      </div>
    </section>
  </body>
</html>