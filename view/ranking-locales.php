      <!-- Modal -->
      <div class="modal-dialog ranking bold uppercase ranking-locales">
        <!-- Modal content-->
        <div class="modal-content mlb-modal">
          <div class="modal-body">
            <img class="ranking-text" src="<?php echo IMGS?>ka/ranking-text.png">
            <img class="ranking-subtext" src="<?php echo IMGS?>ka/ranking-subtext2.png">
            <div class="ranking-container">
              <div class="row-ranking first-row">
                <div>
                  <span class="inline">Supervisor</span>
                  <span class="inline">Direccion</span>
                  <span class="inline">Compras Flia MLB S1</span>
                  <span class="inline">Faltante Flia MLB S1</span>
                  <span class="inline">Compras Core S1</span>
                  <span class="inline">Faltante Core S1</span>
                </div>
              </div>
              <?php foreach($pdvs as $pdv):?>              
              <div class="row-ranking">
                <div class="circle-img left hidden">
                  <img src="<?php echo IMGS?>ka/house.png">
                </div>
                <div>
                  <span class="inline first-column"><?php echo $pdv["supervisor"]?></span>
                  <span class="inline"><?php echo $pdv["direccion"]?></span>
                  <span class="inline"><?php echo $pdv["compras_flia_mlb"]?></span>
                  <span class="inline"><?php echo $pdv["faltantes_flia_mlb"]?></span>
                  <span class="inline"><?php echo $pdv["compras_core"]?></span>
                  <span class="inline"><?php echo $pdv["faltantes_core"]?></span>
                </div>
              </div>
            <?php endforeach;?>
            </div>
          </div>
          <a class="back-home" href="./home.html">
            <img src="<?php echo IMGS?>ka/arrow-left.png">
          </a>
        </div>
      </div>