<?php
  // ispolqzovatq tjuremnyj kamenq
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
  if (!mysql_num_rows ($q)) put_g_error ('возьмите нож в руки');
  $w = mysql_result ($q, 0);
  if (substr ($w, 4, 3) != 'kni') put_g_error ('возьмите нож в руки');
  if (!$p['skills'][37]) put_g_error ('Вы неумеете пользоватся дощечкой!');

  // esli uzhe vybrali edu: 
  if (isset ($_GET['to']))
  {
    $to = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['to']);
    if (!$to) put_g_error ('что резать та?');
    $rez[''] = ':';
    if (!isset ($rez[$to])) exit_msg ('измелчить', 'ничего хорошего из этого не выйдет');
    include_once ('modules/f_gain_item.php');
    $rez[$to] = explode (':', $rez[$to]);
    gain_item ($rez[$to][0], $rez[$to][1], $LOGIN);
  }
  else
  {
    include_once ('modules/f_list_inventory.php');
    $f = list_inventory ($LOGIN, 'i.f.foo', 'use_stand&item='.$item);
    exit_msg ('измелчить', $f);
  }
?>