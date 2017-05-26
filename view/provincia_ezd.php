<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Marlboro Go</title>

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

    <script type="text/javascript">
        $(document).ready(function() { 
          $("#provincia").change(function(){dependencia_estado();});

          $("#provincia_ezd").validate({ 
              rules: {             
                  provincia: { required: true},
                  ezd: { required: true}

              },messages:{
                provincia: "Campo Requerido",                     
                ezd: "Campo Requerido",                     

              }

          });


        });  
      function dependencia_estado()
      {
        var code = $("#provincia").val();
        $.get("<?php echo VIEW?>carga_ezd.php", { code: code },
          function(resultado)
          {
            if(resultado == false)
            {
              alert(" Ocurrio un error de datos.");
            }
            else
            {
              $("#ezd").attr("disabled",false);
              document.getElementById("ezd").options.length=1;
              $('#ezd').append(resultado); 

            }
          }

        );
      }        
      

    </script>
  </head>
  <body>
  <?php include_once("../analyticstracking.php") ?>
    <section class="background-image start-gift-background">
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
        <div class="col-md-6">
          <form class="login-form provincia" name="provincia_ezd" id="provincia_ezd"  method="post" action="confirma_gt_datos.html">
            <div class="input-group">
              <select name="provincia" id="provincia" class="form-control" placeholder="- Provincia">
                <option value="">Seleccione Provincia</option>
                <?php foreach($provincias as $provincia):?>
                <option value="<?php echo $provincia["provincia"]; ?>"> <?php echo $provincia["provincia"]; ?></option>
              <?php endforeach;?>

              </select>
              <img class="input-arg" src="<?php echo IMGS?>gt/arg.png">
            </div>
            <div class="input-group input-separation">
                <select name="ezd" id="ezd"  class="form-control" placeholder="- Ezd">
                <option value="">EZD</option>
                </select>            
              <img class="input-camion" src="<?php echo IMGS?>gt/camion.png">
            </div>
            <div class="button-container">
              <button type="submit" class="btn btn-grey">Aceptar</button>
            </div>
          </form>
        </div>
        <div class="col-md-6"></div>
      </div>
    </section>
  </body>
</html>