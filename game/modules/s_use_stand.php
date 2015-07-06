<?php
  // pozvoljaet ispolqzovatq nepodvizhnuju veshq
  // u kazhdoj nepodvizhnoj veshi estq svoj fail,
  // takchto tut tolqko ego ustanovim i podkljuchim
  $item = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['item']);
  // proverim dejstvitelqno li eta veshq nepodvizhna
  if (substr ($item, 2, 1) != 'o' && substr ($item, 2, 1) != 'l' || substr ($item, 0, 1) != 'i') put_error ('это не неподвижная вещь');
  // proverka estq li v lokacii
  $ci = do_mysql ("SELECT COUNT(*) FROM items WHERE fullname = '".$item."' AND location = '".$p['location']."';");
  $ci = mysql_result ($ci, 0);
  if (!$ci) put_g_error ('у вас в локации нету этой неподвижной вещи');
  // nazvanie faila:
  include_once ('modules/f_real_name.php');
  $rn = real_name ($item);
  $rn = str_replace ('.', '_', $rn);
  $file_name = 'modules/stand/us_'.$rn.'.php';
  // podkljuchaem
  if (file_exists ($file_name))
    include ($file_name);
  else
    exit_msg ('использовать', 'никакого эффекта');
?>