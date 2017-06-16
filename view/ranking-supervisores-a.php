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
                    <td>Puntos promedio</td>
                    <td>Ranking</td>


                  </tr>                  
              <?php foreach($supervisores as $supervisor): 
                if(!$supervisor["locales_ganador_gc"]) $supervisor["locales_ganador_gc"] = 0;
              ?>     
       
                    <tr style="font-size: 12px; text-align: left">
                      <td ><?php echo utf8_encode(addslashes($supervisor["supervisor"]))?></td>
                      <td ><?php echo utf8_encode(addslashes($supervisor["cuenta"]))?></td>
                      <td ><?php echo $supervisor["puntos_promedio"]?></td>
                      <td ><?php echo $supervisor["ranking"]?></td>
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