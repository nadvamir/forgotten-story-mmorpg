<?php
  // podnjatq nekuju veshq
  // uchityvatq chto nado zapisatq v kartu chtoby cherez 10 min opjatq pojavilasq karte prinadlezhashjaja veshq
  require_once ('modules/f_real_name.php'); // tut to ponadobitsja...
  $NO_CONTINUE = 1; // knopku prodolzhitq ne trogatq...
  $item = $_GET['item'];
  $item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
  require_once ('modules/f_take_item.php'); // ona sdelaet bolqshinstvo raboty
  $c = 1;
  if (isset ($_GET['all']))
  {
    // togda dan realname
    $q = do_mysql ("SELECT fullname FROM items WHERE realname = '".$item."' AND location = '".$p['location']."';");
    while ($it = mysql_fetch_assoc ($q))
      take_item ($it['fullname'], $LOGIN);
    $rfn = $item;
  }
  else
  {
    take_item ($item, $LOGIN);
    // esli prodolzhaetsja znachit vzjali
    // nado zanesti v spisok ozhidanija veshej na pojavlenie
    $rfn = real_name ($item);
  }
  //echo 'real name = '.$rfn.'<br/>';
  if (array_key_exists ($rfn, $items))
  {
    // $items podkljuchen v faile s_loadmaps.php
    // znachit nado vernutq
    $time = time();
    $time += 600;
    $nacti = 'item|'.$rfn.'|'.$time;
    $act = do_mysql ("SELECT actions FROM maps WHERE map = '".$pl_map."';");
    $act = mysql_result ($act, 0);
    //echo '<br/>act = '.$act.'<br/>';
    $subc = substr_count ($act, $rfn);
    $itmp = explode (':', $items[$rfn]);
    if ($itmp[2] > $subc)
    {
      if (!$act) $act = $nacti;
      else $act .= '~'.$nacti;
      //echo 'act = '.$act.'<br/>';
      do_mysql ("UPDATE maps SET actions = '".$act."' WHERE map = '".$pl_map."';");
    }
  }
  include 'modules/s_journal.php'; // zhurnal na posledok
?>