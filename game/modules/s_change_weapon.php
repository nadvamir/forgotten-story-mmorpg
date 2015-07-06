<?php
  // pomenjatq oruzhija mestami
  // proverka na wit i dvuruchnoe:
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
  if (!mysql_num_rows ($q)) $weapon = '';
  else $weapon = mysql_result ($q, 0);
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  if (!mysql_num_rows ($q))
  {
    // netu na pojase poetomu prosto na kulaki stavim, toestq snimaem oruzhie na pojas
    if ($weapon) do_mysql ("UPDATE items SET is_in = 'wst' WHERE fullname = '".$weapon."';");
    $action = '';
  }
  else
  {
    $item = mysql_result ($q, 0);
    // tip
    $tp = substr ($item, 4, 3);
    // proverka na dvuruchnoe oruzhie:
    if (strpos ($item, '.2h.') !== false)
    {
      // esli ne luk, to nuzhen navyk:
      if ($p['skills'][40] < 1 && $tp != 'bow' && $tp != 'arb' && $tp != 'spe')  put_g_error ('вы неможете использовать двуручное оружие, у вас нету на это навыков!');
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi';");
      if (mysql_num_rows ($q))
      {
        $shi = mysql_result ($q, 0);
        // snimem wit:
        // esli v inventare eshe estq mesta
        $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
        $c = mysql_result ($q, 0);
        if ($c > $I_SEP_C) put_g_error ('вы неможете снять щит, ваш рюгзак полон!');
        do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$shi."';");
      }
    }
    do_mysql ("UPDATE items SET is_in = 'wea' WHERE fullname = '".$item."';");
    do_mysql ("UPDATE items SET is_in = 'wst' WHERE fullname = '".$weapon."';");
    $action = '';
  }
  $NOACT = 1;
?>