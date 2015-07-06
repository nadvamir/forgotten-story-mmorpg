<?php
  // ispolqzovatq kombo
  $kombo = preg_replace ('/[^a-z0-9_]/i', '', $_GET['kombo']);
  if (!$kombo) put_error ('a gde kombo?');
  if (!isset($_GET['to']))
  {
    include_once ('modules/f_list_inloc.php');
    $inl = list_inloc($LOGIN, 'use_kombo&kombo='.$kombo.'');
    $f = gen_header ('комбо');
    $f .= '<div class="y" id="lidt"><b>выберите цель:</b></div><p>';
    $f .= $inl;
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer();
    exit ($f);
  }
  // podkljuhcaem dlja uznavanija tipa
  if (!file_exists ('modules/kombo/kombo_'.$kombo.'.php')) put_error ('нету файла комбинации');
  include 'modules/kombo/kombo_'.$kombo.'.php';
  $to = preg_replace ('/[^a-z0-9_\.-]/i', '', $_GET['to']);
  if ($to == $LOGIN && !isset ($HEAL))  put_g_error ('такие комбинации на себя иснользовать особого смысла нету ;)');
  if (isset ($HEAL) && $to != $LOGIN) put_g_error ('лечить лишь себя так можно');
  
  //echo $to;
  //echo ' '.(is_player($to)).' '.(substr($to, 0, 2));
  if (!is_player($to) && substr ($to, 0, 2) != 'n.') put_error ('только для живых объектов');
  include_once ("modules/f_check_last_attack.php");
  if (check_last_attack ($LOGIN))
  {
    include_once ("modules/f_upd_last_attack.php");
    upd_last_attack ($LOGIN);
    include_once ('modules/f_comp_reaction.php');
    include_once ('modules/f_is_attack_successful.php');
    if (isset ($DMG) && (!is_attack_successful ($LOGIN, $to) || !comp_reaction ($LOGIN, $to)))
    {

      // sqedaem manu
      include_once ('modules/f_search_kombo.php');
      $k = search_kombo ($LOGIN, $kombo);
      if (!$k) put_g_error ('нету такой комбинации');
      // hvataet li many -
      for ($i = 1; $i < $k[1]; $i++) $MANA += $MANAP;
      $p['mana'][0] -= $MANA;
      if ($p['mana'][0] < 0) put_g_error ('нехватает маны');
      $nmana = $p['mana'][0].'|'.$p['mana'][1];
      do_mysql ("UPDATE players SET mana = '".$nmana."' WHERE id_player = '".$p['id_player']."';");

      $id = is_player ($to);
      if ($id)
      {
        $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
        $name = mysql_result ($q, 0);
      }
      else
      {
        $id = is_npc ($to);
        $q = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$id."';");
        if (!mysql_num_rows ($q)) include 'modules/s_main.php';
        $name = mysql_result ($q, 0);
      }
      add_journal ($name.' блокировал прием '.$LOGIN.'!', 'l.'.$p['location']);
    }
    else
    {
      // dalee, budem razbiratsja.
      // teperq smotrim dejstvija kombo - 
      include_once ('modules/f_search_kombo.php');
      $k = search_kombo ($LOGIN, $kombo);
      if (!$k) put_g_error ('нету такой комбинации');
      // hvataet li many -
      for ($i = 1; $i < $k[1]; $i++) $MANA += $MANAP;
      $p['mana'][0] -= $MANA;
      if ($p['mana'][0] < 0) put_g_error ('нехватает маны');
      if (isset ($EFFECT))
      {
        // dobavim kakojnibudq effekt
        if ($EFFECT == 'krovotechenie')
        {
          include_once ('modules/f_start_blood.php');
          start_blood ($to);
        }
        else
        {
          include_once ('modules/f_set_affected.php');
          set_affected ($to, $EFFECT);
        }
      }
      if (isset ($HEAL))
      {
        // podlechim sebja:
        if ($p['life'][0] == $p['life'][1]) put_g_error ('вы здоровы');
        for ($i = 1; $i < $k[1]; $i++) $HEAL += $HEALP;
        $p['life'][0] += $HEAL;
        if ($p['life'][0] > $p['life'][1]) $p['life'][0] = $p['life'][1];
      }
      $nmana = $p['mana'][0].'|'.$p['mana'][1];
      $nlife = $p['life'][0].'|'.$p['life'][1];
      $tok = 20;
      for ($a = 1; $a < $k[1]; $a++) $tok *= 2;
      $k[2] += 1;
      if ($k[2] >= $tok)
      {
        // podnimem urovenq - 
        $k[1]++;
        $k[2] = 0;
        add_journal ('новый уровень приема!', $LOGIN);
      }
      $i = $k[3];
      $p['kombo'][$i] = $k[0].':'.$k[1].':'.$k[2];
      $nkombo = implode ('|', $p['kombo']);
      do_mysql ("UPDATE players SET life = '".$nlife."', mana = '".$nmana."', kombo = '".$nkombo."' WHERE id_player = '".$p['id_player']."';");
      if (isset ($DMG))
      {
        // napadaem -
        include_once ('modules/f_attack.php');
        attack ($LOGIN, $to);
        for ($i = 1; $i < $k[1]; $i++) $DMG += $DMGP;
        // v dalqnejshem, nanesem udar, cherez normalqnye funkcii
        include_once ('modules/f_do_dmg.php');
        if (!isset ($TYPE)) $TYPE = 'non';
        do_dmg ($LOGIN, $to, $TYPE, 0, $DMG);
      }
      add_journal ($JRN, 'l.'.$p['location']);
    }
  }
?>