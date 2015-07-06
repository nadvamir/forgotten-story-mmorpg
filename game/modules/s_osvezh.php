<?php
  // osvezhitq
  $dead = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['dead']);
  if (!$dead) put_error ('а какой труп то резать!!?');
  $q = do_mysql ("SELECT * FROM dead WHERE location = '".$p['location']."' AND fullname = '".$dead."';");
  if (!mysql_num_rows ($q)) put_g_error ('нет такого trupa');
  $di = mysql_fetch_assoc($q);
  // infa trupa

  if (!$di['hunt']) put_g_error ('на трупе ничего нету!');
  // esli estq nozh odetyj
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
  $q2 = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  if (!mysql_num_rows ($q) && !mysql_num_rows ($q2)) put_g_error ('возьмите в руки нож!');
  if (!mysql_num_rows ($q)) $weapon = '';
  else $weapon = mysql_result ($q, 0);
  if (!mysql_num_rows ($q2)) $w2 = '';
  else $w2 = mysql_result ($q2, 0);
  if (substr($weapon, 0, 7) != 'i.w.kni' && substr($w2, 0, 7) != 'i.w.kni') put_g_error ('возьмите в руки нож!');
  // esli vse estq, to togda osvezhivaem - sozdaem veshi i puskaem ih na has
  if (strpos ($di['hunt'], '|')) $di['hunt'] = explode ('|', $di['hunt']);
  else $di['hunt'] = explode ('~', $di['hunt']);
  $c = count ($di['hunt']);
  for ($i = 0; $i < $c; $i++)
  {
    include_once ('modules/f_create_item.php');
    $trof = create_item ($di['hunt'][$i]);
    do_mysql ("UPDATE items SET map = '".$di['map']."', belongs = '".$dead."' WHERE fullname = '".$trof."';");
  }
  do_mysql ("UPDATE dead SET hunt = '' WHERE fullname = '".$di['fullname']."';");
  $OSVEZH = 1;
  include 'modules/s_take_dead.php';
?>