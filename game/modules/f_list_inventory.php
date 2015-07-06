<?php
  // funkcija predostavljaet list inventarja::
  // po ukazanomu filqtru. on obezatelen, no dlja vseh veshej na mesto filqtra mozhno vvesti 'i.'
  function list_inventory ($login, $mask, $action)
  {
    global $sid;
    global $p;
    //$login = mysql_real_escape_string ($login);
    //$mask = mysql_real_escape_string ($mask);
    $action = preg_replace ('/[^a-z0-9_&=\.]/i', '', $action);

    $f = '';
    $q = do_mysql ("SELECT id_item, name, fullname, on_drop FROM items WHERE belongs = '".$login."' AND is_in = 'inv' AND realname LIKE '".$mask."%';");
    while ($i = mysql_fetch_assoc ($q))
    {
      if (substr ($i['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) $i['name'] = $i['on_drop'];
      $qua = substr ($i['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action='.$action.'&to='.$i['fullname'].'&id_item='.$i['id_item'].'">';
      $f .= $i['name'].'</a><br/>';
    }
    return $f;
  }
?>