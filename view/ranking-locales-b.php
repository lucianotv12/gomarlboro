      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
 
             <table class="table table-responsive" >
              <tr><td colspan="8" style="text-align: center;">ACUMULADO SEMANA 3</td></tr>

              <tr style="text-align: left">
                <td width="160px">Supervisor</td>
                <td width="160px">Direccion</td>
                <td>Compras <br/> flia mlb</td>
                <td>Faltante <br/> ob</td>
                <td>Compras <br/>core</td>
                <td>Faltante <br/> ob</td>
                <td>Cupones</td>

              </tr>
            </table>  
            <div class="ranking-container">
                  <table class="table table-responsive" >
              <?php foreach($pdvs as $pdv): 
                if(strlen($pdv["supervisor"]) > 30):
                 $pdv["supervisor"] = substr($pdv["supervisor"], 0, 27) . "...";
                endif;
                if(strlen($pdv["direccion"]) > 30):
                 $pdv["direccion"] = substr($pdv["direccion"], 0, 27) . "...";
                endif;                
                if($pdv["compras_flia_mlb"] < 0): $pdv["compras_flia_mlb"] = 0; endif;
                if($pdv["faltantes_flia_mlb"] < 0): $pdv["faltantes_flia_mlb"] = 0; endif;
                if($pdv["compras_core"] < 0): $pdv["compras_core"] = 0; endif;
                if($pdv["faltantes_core"] < 0): $pdv["faltantes_core"] = 0; endif;

              ?>     
       
                    <tr style="font-size: 12px; text-align: left">
                      <td width="160px" ><?php echo utf8_encode(addslashes($pdv["supervisor"]))?></td>
                      <td width="160px"><?php echo utf8_encode(addslashes($pdv["direccion"]))?></td>
                      <td ><?php echo $pdv["compras_flia_mlb"]?></td>
                      <td ><?php echo $pdv["faltantes_flia_mlb"]?></td>
                      <td ><?php echo $pdv["compras_core"]?></td>
                      <td ><?php echo $pdv["faltantes_core"]?></td>
                      <td ><?php echo $pdv["cupones"]?></td>
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