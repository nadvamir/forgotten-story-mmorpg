<?php
  // vozvrashjaet region, v kotorom sehchas igrok
  // ispolqzovatq posle get_pl_info
  function get_pl_region ()
  {
    global $p;
    $reg = explode ('|', $p['location']);
    return $reg[0];
  }
?>