<?php
  // poluchjaet ves veshi
  function get_weight ($item)
  {
    # do_mysql();
    //$item = preg_replace ('/[^a-z0-9_\.]/i', '', $item);
    $a = do_mysql ("SELECT weight FROM items WHERE fullname = '".$item."';");
    $w = mysql_result ($a, 0);
    return $w;
  }
?>