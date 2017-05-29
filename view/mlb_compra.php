
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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
  </head>
  <body>
    <script type="text/javascript">
    $( document ).ready(function() {
      var percentage = 0.25;

      var browserData = [
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true},
          {color: '#4f7282', y: 1, sliced: true}
      ]

      var quotient = Math.floor(percentage*12);
      for (var i = 0; i < quotient; i++){
          browserData[i].color = '#dc1e25';
      }

      // Create the chart
      Highcharts.chart('chart', {
          title: {
            text:null
          },
          chart: {
              type: 'pie',
              backgroundColor: null,
              plotBackgroundColor: 'none',
              plotBorderWidth: 0,
              plotShadow: false
          },
          plotOptions: {
              pie: {
                  shadow: false,
                  borderWidth: null
              }
          },
          tooltip: {
            enabled: false
          },
          series: [{
              name: 'Browsers',
              data: browserData,
              size: '80%',
              innerSize: '60%',
              dataLabels: false,
              states: {
                hover: false
              }
          }],
          exporting: false,
          credits: {
            enabled: false
          }
      });
    });  
    </script>
    <section class="background-image home-background home-modal-background modal-gt-back">
      <nav id="menu" class="navbar navbar-default">
        <div class="container full-width-mobile">
          <!-- DESKTOP MENU -->
          <div class="menu-container bold hidden-mobile">
            <img src="<?php echo IMGS?>gt/menu.png">
            <button type="button" class="btn-arrow dropdown-toggle down" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
            <div class="chances-container">
              <?php if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"): ?>            
                 <p>Puntos Acumulados <span style="font-size: 20px">10</span></p>
               <?php else:?>
                 <p>Chances Acumuladas <span style="font-size: 20px">10</span></p>
                <?php endif;?>
            </div>
            <ul class="dropdown-menu">
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo HOME?>premios_GT.html">Premios</a></li>
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
            <div class="chances-acumuladas">
              <?php if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"): ?>            
                 <p>Puntos Acumulados <span style="font-size: 20px">10</span></p>
               <?php else:?>
                 <p>Chances Acumuladas <span style="font-size: 20px">10</span></p>
                <?php endif;?>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li><a href="#">Bases y condiciones</a></li>
                <li role="separator" class="divider"></li>
              <li><a href="<?php echo HOME?>premios_GT.html">Premios</a></li>
                <li role="separator" class="divider"></li>
              <li><a  href="https://www.marlboro.com.ar">Web marlboro</a></li>
                <li role="separator" class="divider"></li>
                <li class="salir"><a href="#">Salir</a></li>
              </ul>
            </div>
          </div>
          <!-- END MOBILE MENU  -->
        </div>
      </nav>

      <div class="container gt-modal popin">
        <!-- Modal -->
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content mlb-modal box-1">
            <div class="modal-body">
            <span id="muestra_objetivo"><?php echo $_usuario->objetivo?></span>
              <img src="<?php echo IMGS?>gt/<?php echo $img_muestra?>">
            </div>
            <a class="back-home" href="./home.html">
              <img src="<?php echo IMGS?>ka/arrow-left.png">
            </a>
          </div>
          <div class="chart-container bold">
            <div><span class="red">AVANCE </span><span>VS. OBJETIVO</span></div>
            <div class="percentage red">00%</div>
            <div id="chart"></div>
          </div>
        </div>
      </div>

        <div class="bottom-text bold">
          
          <p>¡No dejes que nada te frene hasta ser uno de los ganadores!</p>
        </div>
        <div class="bottom-container bold chances" style="margin-top: 20px">
          <button type="button" class="btn btn-grey btn-red inline">
            <span class="grey hidden-mobile">llevas acumuladas </span><span class="grey hidden-desktop">chances acumuladas </span><span>(10)</span><span class="grey hidden-mobile"> chances</span>
          </button>

        </div>
      </div>

    </section>
  </body>
</html>