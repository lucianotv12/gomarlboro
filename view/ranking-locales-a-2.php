      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
             <table class="table table-responsive" >
              <tr><td colspan="8" style="text-align: center;">ACUMULADO SEMANA 4</td></tr>

                <tr>
                  <td width="140px" >Supervisor</td>
                  <td width="140px" >Direccion</td>
                  <td>Puntaje <br/>OB.Codigos</td>
                  <td>Compras</td>
                  <td>OB.Compras</td>
                  <td>Ventas</td>
                  <td>OB.Ventas</td>
                  <td>Compras FB</td>
                  <td>OB.Compras FB</td>
                  <td>Visibilidad</td>
                  <td>Stock</td>

                </tr>
            </table>              
            <div class="ranking-container">

                  <table class="table table-responsive" >



              <?php foreach($pdvs as $pdv): 
                if(strlen($pdv["supervisor"]) > 22):
                 $pdv["supervisor"] = substr($pdv["supervisor"], 0, 19) . "...";
                endif;
                if(strlen($pdv["direccion"]) > 22):
                 $pdv["direccion"] = substr($pdv["direccion"], 0, 19) . "...";
                endif;                

              ?>     
       
                    <tr style="font-size: 12px; text-align: left;">
                      <td style="text-align: center" width="140px" ><?php echo utf8_encode(addslashes($pdv["supervisor"]))?></td>
                      <td style="text-align: center" width="140px"><?php echo utf8_encode(addslashes($pdv["direccion"]))?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["cupones"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["compras_mlb"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["compras_ob"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["ventas_mlb"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["ventas_ob"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["compras_fb"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["compras_fb_ob"]?></td>                      
                      <td style="text-align: center" width="100px"><?php echo $pdv["visibilidad"]?></td>
                      <td style="text-align: center" width="100px"><?php echo $pdv["stock"]?></td>

                    </tr>

            <?php endforeach;?>
               </table>

            </div>
          </div>
          <a class="back-home" href="./home.html">
            <img src="<?php echo IMGS?>ka/arrow-left.png">
          </a>
        </div>
      </div>