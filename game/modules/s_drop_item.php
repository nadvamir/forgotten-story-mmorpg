<?php
  // podnjatq nekuju veshq
  // nado udalitq iz karty chto uzhe estq
  require_once ('modules/f_real_name.php'); // tut to ponadobitsja...
  $NO_CONTINUE = 1; // knopku prodolzhitq ne trogatq...
  $item = $_GET['item'];
  $item = preg_replace ('/[^a-z0-9\._\|]/i', '', $item);
  require_once ('modules/f_drop_item.php'); // ona sdelaet bolqshinstvo raboty
  $q = do_mysql ("SELECT realname FROM items WHERE fullname = '".$item."';");
  if (!mysql_num_rows ($q)) put_error ('вешь не найдена'); 
  $rn = mysql_result ($q, 0);

  $type = substr ($rn, 2, 1);
  switch ($type)
  {
    case 'f': $_GET['type'] = 1; break;
    case 'q': case 'm': $_GET['type'] = 2; break;
    case 'w': $_GET['type'] = 3; break;
    case 'a': case 'x': $_GET['type'] = 4; break;
    default: $_GET['type'] = 5; break;
  }

  $lim = '';
  if (!isset ($_GET['all'])) $lim = 'LIMIT 1';
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$rn."' ".$lim.";");
  while ($i = mysql_fetch_assoc ($q))
  {
    $item = $i['fullname'];
    drop_item ($item, $LOGIN);
    // esli prodolzhaetsja znachit vzjali
    // nado zanesti v spisok ozhidanija veshej na pojavlenie
    $rfn = $rn;
    if (array_key_exists ($rfn, $items))
    {
      // $items podkljuchen v faile s_loadmaps.php
      // znachit nado udalitq avto obnovu
      $act = do_mysql ("SELECT actions FROM maps WHERE map = '".$pl_map."';");
      $act = mysql_result ($act, 0);
      //echo '$act = '.$act.'<br/>';
      if (strpos ($act, '~') === false && strpos ($act, $rfn) > 0) $act = '';
      else
      {
        $act = explode ('~', $act);
        $cou = count($act);
        for ($i = 0; $i < $cou; $i++)
        {
          if (strpos ($act[$i], $rfn) > 0)
          {
            unset ($act[$i]);
            break;
          }
        }
        $act = implode ('~', $act);
      }
      do_mysql ("UPDATE maps SET actions = '".$act."' WHERE map = '".$pl_map."';");
    }
  }
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>