<?php
  // funkcija udaljaet von veshq
  // otovsjudu
  function delete_item ($item)
  {
    //$item = preg_replace ('/[^a-z0-9_\.]/i', '', $item);
    // berem informaciju veshi
    do_mysql ("DELETE FROM items WHERE fullname = '".$item."';");
  }
?>