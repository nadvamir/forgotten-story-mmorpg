<?php
  // fail razgovora npc
  // proverjaem, estq li fail ragovora
  $npc = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['npc']);
  if (!isset ($_GET['part'])) $part = 'start';
  else $part = preg_replace ('/[^a-z0-9_]/i', '', $_GET['part']);
  $nid = is_npc ($npc);
  $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE id_npc = '".$nid."' AND location = '".$p['location']."' AND type = 's';");
  if (!mysql_num_rows($q)) put_g_error ('с вами рядом такого нет!');
  include_once ('modules/f_real_name.php');
  $rnpc = real_name ($npc);
  $fn = str_replace ('.', '_', $rnpc);
  if (substr ($npc, 2, 1) == 't')
  {
    if (!file_exists('modules/npc/t/sf_'.$fn.'.php')) 
      include 'modules/s_trade.php';
    include 'modules/npc/t/sf_'.$fn.'.php';
  }
  else
  {
    if (!file_exists('modules/npc/s/sf_'.$fn.'.php')) put_error ('файла разговора '.$fn.' не найденно');
    include 'modules/npc/s/sf_'.$fn.'.php';
  }
  //--------------------
  // kvest esli estq
  $q = do_mysql ("SELECT quest FROM npc WHERE id_npc = '".$nid."';");
  $qst = mysql_result ($q, 0);
  if ($qst)
  {
    // podkljuchaem fail questa 
    if (!file_exists ('modules/quests/q_'.$qst.'.php')) put_error ('нету файла квеста '.$qst.'!');
    include ('modules/quests/q_'.$qst.'.php');
  }
  //--------------------
  // shag pervyj - nahodim i vybiraem nuzhnuju chastq dialoga
  if ($qst) $spf['start'] .= '|quest~у тебя нету кокого-нибудь задания для меня?';
  if (!array_key_exists ($part, $spf)) put_error ('такой темы для разговора не существует!');
  $them = $spf[$part];
  $them = explode ('|', $them);
  $alo = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$nid."';");
  $name = mysql_result ($alo, 0);
  $f = gen_header ($name);
  $f .= '<div class="y" id="oiad"><b>'.$name.' говорит:</b></div><p>';
  $f .= $them[0].'<br/>';
  $f .= '_______________<br/>';
  // teperq nuzhno poluchitq varianty otveta:
  $c = count ($them);
  for ($i = 1; $i < $c; $i++)
  {
    $them[$i] = explode ('~', $them[$i]);
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=speak_npc&npc='.$npc.'&part='.$them[$i][0].'">';
    $f .= $them[$i][1].'</a><br/>';
  }
  
  if (substr ($npc, 2, 1) == 't') $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'">торг</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>