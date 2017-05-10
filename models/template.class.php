<?php

class Template
{
	function draw_header($site=0)
	{   
//   header('X-Frame-Options: SAMEORIGIN'); // FF 3.6.9+ Chrome 4.1+ IE 8+ Safari 4+ Opera 10.5+

   date_default_timezone_set('America/Argentina/Buenos_Aires');
   $_hora= date ("H:i:s");
   $_usuario = unserialize($_SESSION["user"]);
   if($_usuario->mecanica == "A"):
      $link_premios =  HOME . "premios.html";
      $link_bases = HOME . "basesycondiciones.html";
   elseif($_usuario->mecanica == "B"):
      $link_premios =  HOME . "premiosB.html";
      $link_bases = HOME . "basesycondicionesb.html";
   
   endif; 

   ?>
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
    <script type="text/javascript">
      $(document).ready(function() {
        $("#box-1").click(function(){
          $("#link-1")[0].click();
        });
        $("#box-2").click(function(){
          $("#link-2")[0].click();
        });
        $("#box-3").click(function(){
          $("#link-3")[0].click();
        });
        $("#box-4").click(function(){
          $("#link-4")[0].click();
        });
        $("#box-5").click(function(){
          $("#link-5")[0].click();
        });        
      });
    </script> 
    <?php if($site == "home"):?>  
      <section class="background-image home-background full">
    <?php elseif($site == "premios"):?>  
      <section class="background-image premios2-background">
    <?php elseif($site == "premiosb"):?>  
      <div class="container separation-nav hidden-desktop premios">
    <?php else: ?>
      <section class="background-image home-background home-modal-background">
    <?php endif;?>    
      <nav id="menu" class="navbar navbar-default">
        <div class="container full-width-mobile">
          <!-- DESKTOP MENU -->
          <div class="menu-container bold hidden-mobile">
           <a href="<?php echo HOME?>home.html"> <img src="<?php echo IMGS?>gt/menu.png"></a>
            <button type="button" class="btn-arrow dropdown-toggle down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <ul class="dropdown-menu">
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo $link_premios?>">Premios</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo $link_bases ?>">Bases y condiciones</a></li>
              <li role="separator" class="divider"></li>
              <li><a target="_blank" href="https://www.marlboro.com.ar">Web marlboro</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo HOME?>video.html">Video tutorial</a></li>
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
              <a class="navbar-brand"  href="<?php echo HOME?>home.html">
                <img src="<?php echo IMGS?>gt/go-marlboro-title.png">
              </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="<?php echo $link_bases ?>">Bases y condiciones</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo $link_premios?>">Premios</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="https://www.marlboro.com.ar">Web marlboro</a></li>
                <li role="separator" class="divider"></li>
                <li class="salir"><a href="<?php echo HOME ?>">Salir</a></li>
              </ul>
            </div>
          </div>
          <!-- END MOBILE MENU  -->
        </div>
      </nav>
          
<?php

  }

	function draw_footer($site=0)
	{ 

	?>


      <div class="container hidden-mobile">
        <?php if($site != "home"):?>  
        <div class="bottom-text bold">
          <p>¡Aprovechá todas las oportunidades de sumar y ganá con marlboro!</p>
          <p>¡No dejes que nada te frene!</p>
        </div>
        <?php endif;?>
        <div class="bottom-container bold">
          <a href="<?php echo HOME?>ranking.html" class="btn btn-grey btn-red inline">
            <span class="grey">tu </span><span>performance</span>
          </a>
          <span class="btn-sep inline hidden-mobile"></span>
          <a href="<?php echo HOME?>ranking-locales.html" class="btn btn-grey btn-red inline">
            <span>performance </span><span class="grey">locales</span>
          </a>
          <div class="gift-small-container">
            <img src="<?php echo IMGS?>gif/moto-gift.gif">
          </div>
        </div>
      </div>
    </section>
  </body>
</html>

	<?php
	}
}
?>