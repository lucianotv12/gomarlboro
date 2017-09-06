      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
 

            <div class="ranking-container">
                  <table class="table table-responsive" >
                  <tr style="text-align: left">
                    <td >Supervisor</td>
                    <td >Cuenta</td>
                    <td>Pos Total</td>
                    <td>Pos CG <br/> Ganadores </td>
                    <TD>%</TD>
                    <td>¿GANA?</td>
                    <td>EFECTIVIDAD <BR/> TOTAL</td>
                    <td>sORTEO MOTO</td>

                  </tr>                  
              <?php foreach($supervisores as $supervisor): 
                if(!$supervisor["locales_ganador_gc"]) $supervisor["locales_ganador_gc"] = 0;
              ?>     
       
                    <tr style="font-size: 12px; text-align: left">
                      <td ><?php echo utf8_encode(addslashes($supervisor["supervisor"]))?></td>
                      <td ><?php echo utf8_encode(addslashes($supervisor["cuenta"]))?></td>
                      <td ><?php echo $supervisor["A"]?></td>
                      <td ><?php echo $supervisor["B"]?></td>
                      <td ><?php echo $supervisor["C"]?> %</td>
                      <td ><?php echo $supervisor["D"]?></td>
                      <td ><?php echo $supervisor["E"]?></td>
                      <td ><?php echo $supervisor["F"]?></td>
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