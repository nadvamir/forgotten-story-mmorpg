<?php
  // portal
  $q = do_mysql ("SELECT on_take, on_drop FROM items WHERE fullname = '".$item."';");
  $ii = mysql_fetch_assoc ($q);
  include_once ('modules/f_teleport.php');
  teleport ($LOGIN, $ii['on_take']);
?>