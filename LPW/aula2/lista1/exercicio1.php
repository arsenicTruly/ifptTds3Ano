<?php

$cores = array("yellow","blue","black","green","red","purple","grey","brown");

foreach($cores as $cor){ 
    ?>
    <div style="background-color:<?php echo $cor; ?>; width: 100px; height: 100px;"></div>
    <?php
}
