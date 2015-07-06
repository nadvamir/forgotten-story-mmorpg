<?php
  // beret nazvanie veshi
  function get_it_name ($item)
  {
    # do_mysql();
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $a = do_mysql ("SELECT name, on_drop FROM items WHERE fullname = '".$item."';");
    $w = mysql_fetch_assoc ($a);
    if (substr ($item, 4, 3) == 'tra') return $w['on_drop'];
    return $w['name'];
  }
?>