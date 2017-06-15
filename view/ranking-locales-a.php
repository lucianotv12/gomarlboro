      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
            <div class="ranking-container">

                  <table class="table table-responsive" >
              <tr><td colspan="8" style="text-align: center;">ACUMULADO SEMANA 3</td></tr>

                <tr>
                  <td width="120px" >Supervisor</td>
                  <td width="120px" >Direccion</td>
                  <td>Puntaje</td>
                  <td>Compras <br/> f.mlb</td>
                  <td>Total</td>
                  <td>Ventas <br/> f.mlb</td>
                  <td>Total</td>                      
                  <td>Compras <br/>core</td>
                  <td>Total</td>
                  <td>Stock flia <BR/>MLB 7.6</td>
                  <td>Visibilidad 7.6</td>
                  <td>Puntaje <br/>total</td>
                  <td>IMP. GC <BR/>PDV GANADOR</td>
                </tr>


              <?php foreach($pdvs as $pdv): 
                if(strlen($pdv["supervisor"]) > 22):
                 $pdv["supervisor"] = substr($pdv["supervisor"], 0, 19) . "...";
                endif;
                if(strlen($pdv["direccion"]) > 22):
                 $pdv["direccion"] = substr($pdv["direccion"], 0, 19) . "...";
                endif;                
                if($pdv["compras_flia_mlb"] < 0): $pdv["compras_flia_mlb"] = 0; endif;
                if($pdv["faltantes_flia_mlb"] < 0): $pdv["faltantes_flia_mlb"] = 0; endif;
                if($pdv["ventas_flia_mlb"] < 0): $pdv["ventas_flia_mlb"] = 0; endif;
                if($pdv["faltantes_ventas"] < 0): $pdv["faltantes_ventas"] = 0; endif;
                if($pdv["compras_core"] < 0): $pdv["compras_core"] = 0; endif;
                if($pdv["faltantes_core"] < 0): $pdv["faltantes_core"] = 0; endif;
                if($pdv["ventas_core"] < 0): $pdv["ventas_core"] = 0; endif;
                if($pdv["faltantes_ventas_core"] < 0): $pdv["faltantes_ventas_core"] = 0; endif;

              ?>     
       
                    <tr style="font-size: 12px; text-align: left;">
                      <td  width="120px" ><?php echo utf8_encode(addslashes($pdv["supervisor"]))?></td>
                      <td  width="120px"><?php echo utf8_encode(addslashes($pdv["direccion"]))?></td>
                      <td ><?php echo $pdv["cupones"]?></td>
                      <td ><?php echo $pdv["compras_flia_mlb"]?></td>
                      <td ><?php echo $pdv["faltantes_flia_mlb"]?></td>
                      <td ><?php echo $pdv["ventas_flia_mlb"]?></td>
                      <td ><?php echo $pdv["faltantes_ventas"]?></td>
                      <td ><?php echo $pdv["compras_core"]?></td>
                      <td ><?php echo $pdv["faltantes_core"]?></td>
                      <td ><?php echo $pdv["chequeo_2"]?></td>
                      <td ><?php echo $pdv["chequeo_3"]?></td>
                      <td ><?php echo $pdv["puntaje_total"]?></td>
                      <td ><?php echo $pdv["importe_gc"]?></td>



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