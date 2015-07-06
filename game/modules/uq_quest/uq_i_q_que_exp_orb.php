<?php
  // sfera opyta
  // mgnovenno daet kuchu opyta
  if (time() - $p['last'][6] < 43200) put_g_error ('с момента последнего использования сферы еще не прошло 12 часов');
  $exp = $p['stats'][2] * 0.5 / $p['stats'][0];
  include_once ('modules/f_gain_peace_exp.php');
  include_once ('modules/f_delete_item.php');
  gain_peace_exp ($exp, $LOGIN);
  delete_item ($item);
  $p['last'][6] = time();
  $last = implode ('|', $p['last']);
  do_mysql ("UPDATE players SET last = '".$last."' WHERE login = '".$LOGIN."';");
?>