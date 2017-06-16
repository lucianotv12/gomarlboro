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
                <td width="160px">Cuenta</td>
                <td>Pos Total</td>
                <td>Pos CG <br/> Ganadores </td>
                <td>Locales <br/> Ganadores CG</td>
                <td>¿GANA?</td>

              </tr>
            </table>  
            <div class="ranking-container">
                  <table class="table table-responsive" >
              <?php foreach($supervisores as $supervisor): ?>     
       
                    <tr style="font-size: 12px; text-align: left">
                      <td ><?php echo utf8_encode(addslashes($supervisor["supervisor"]))?></td>
                      <td ><?php echo utf8_encode(addslashes($supervisor["cuenta"]))?></td>
                      <td ><?php echo $supervisor["pos_total"]?></td>
                      <td ><?php echo $supervisor["ganadores_gc"]?></td>
                      <td ><?php echo $supervisor["locales_ganadores_gc"]?></td>
                      <td ><?php echo $supervisor["gana"]?></td>
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