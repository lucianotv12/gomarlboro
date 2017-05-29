      <div class="container separation-nav-gt">
        <div class="home-text hidden-desktop">
          <?php if($_usuario->provincia == "MENDOZA" or $_usuario->provincia == "SALTA" or $_usuario->provincia == "RIO NEGRO" or $_usuario->provincia == "NEUQUEN"):?>
            <img src="<?php echo IMGS?>mobile/home-text-PUNTOS-MOBILE.png">
          <?php else:?>
            <img src="<?php echo IMGS?>mobile/home-text-CHANCES-MOBILE.png">
          <?php endif;?>  
        </div>
        <div class="boxes-container bold botones-2">
          <div class="col-md-6">
            <div id="box-1" class="box-container">
              <img src="<?php echo IMGS?>gt/cart.png">
              <p>comprá marlboro</p>
            </div>
            <a id="link-1" class="hidden" href="<?php echo HOME?>mlb_compra.html"></a>
          </div>
          <div class="col-md-6">
            <div id="box-2" class="box-container">
              <img src="<?php echo IMGS?>gt/x2.png">
              <p>malboro core vale doble</p>
            </div>
            <a id="link-2" class="hidden" href="<?php echo HOME?>mrl_core.html"></a>
          </div>
        </div>
        <div>
        </div>
  </div>

