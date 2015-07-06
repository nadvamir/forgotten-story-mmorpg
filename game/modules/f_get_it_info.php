<?php
  // funkcija poluchjaet vsju informaciju veshi
  function get_it_info ($item)
  {
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $q = do_mysql ("SELECT * FROM items WHERE fullname = '".$item."';");
    $nit = mysql_fetch_assoc ($q);
    return $nit;
  }
?>