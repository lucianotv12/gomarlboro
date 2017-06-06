      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
            <div class="ranking-container">

                  <table class="table table-responsive" >
                    <tr><td colspan="8" style="text-align: center;">SEMANA 3</td></tr>
                    <tr>
                      <td>Supervisor</td>
                      <td>Direccion</td>
                      <td>Compras <br/> f.mlb</td>
                      <td>Faltante <br/> OB</td>
                      <td>Ventas <br/> f.mlb</td>
                      <td>Faltante <br/> OB</td>                      
                      <td>Compras <br/>core</td>
                      <td>Faltante <br/> OB</td>
                      <td>Ventas <br/>core</td>
                      <td>Faltante <br/> OB</td>

                      <td>Cupones</td>
                    </tr>


              <?php foreach($pdvs as $pdv): ?>     
       
                    <tr style="font-size: 12px">
                      <td  ><?php echo utf8_encode(addslashes($pdv["supervisor"]))?></td>
                      <td ><?php echo utf8_encode(addslashes($pdv["direccion"]))?></td>
                      <td ><?php echo $pdv["compras_flia_mlb"]?></td>
                      <td ><?php echo $pdv["faltantes_flia_mlb"]?></td>
                      <td ><?php echo $pdv["ventas_flia_mlb"]?></td>
                      <td ><?php echo $pdv["faltantes_ventas"]?></td>
                      <td ><?php echo $pdv["compras_core"]?></td>
                      <td ><?php echo $pdv["faltantes_core"]?></td>
                      <td ><?php echo $pdv["ventas_core"]?></td>
                      <td ><?php echo $pdv["faltantes_ventas_core"]?></td>

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