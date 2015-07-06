<?php
  // funkcija sozdaet effekt ili prodlivaet esli on estq
  function set_affected ($name, $effect, $time = 0)
  {
    //$name = preg_replace ('/[^a-z\._0-9]/i', '', $name);
    //$effect = preg_replace ('/[^a-z]/i', '', $effect);
    // effecty i prodolzhitelqnostq
    $eff['oglushen'] = 15;
    $eff['zamerz'] = 15;
    $eff['okamenel'] = 15;
    $eff['odubel'] = 15;
    $eff['paralizovan'] = 30;
    $eff['gorit'] = 600; // npc
    $eff['otravlen'] = 600; // npc
    $eff['krovotechenie'] = 600; // npc
    $eff['prokljat'] = 300;
    $eff['ispugan'] = 30;
    $eff['blagoslavlen'] = 300;
    $eff['osleplen'] = 60;
    $eff['zarazhen'] = 1800;
    $eff['zamedlen'] = 180;
    $eff['hamelion'] = 1800; // nik ele viden
    $eff['blagouhanie'] = 600;
    $eff['prosvetlenie'] = 600;
    $eff['jarostq'] = 600;
    $eff['skorostq'] = 600;
    $eff['koordinacija'] = 600;
    $eff['pqjan'] = 60;

    $eff['aura_magii'] = 600;
    $eff['aura_plameni'] = 600;
    $eff['aura_lqda'] = 600;
    $eff['aura_efira'] = 600;
    $eff['aura_vetra'] = 600;
    $eff['aura_illjuzii'] = 600;
    $eff['aura_podzemelqja'] = 600;
    $eff['aura_elqfov'] = 600;
    $eff['aura_moguwestvennyh'] = 600;

    $eff['pryzhok'] = 1800;
    $eff['levitacija'] = 1800;
    $eff['udacha'] = 600;

    if (strpos ($effect, '|')) 
    {
      $e = explode ('|', $effect);
      $effect = $e[0];
      $eff[$effect] *= 0.7 + ($e[1] / 10);
    }

    if (!array_key_exists ($effect, $eff)) return 0;

    // chelu
    $id = is_player ($name);
    if ($id)
    {
      // acaunt proverim
      $q = do_mysql ("SELECT account FROM players WHERE id_player = '".$id."';");
      $acc = mysql_result ($q, 0);
      if ($acc == 2 || $acc == 4) return 1;
      // krovotechenie jad i ogonq otdelqno
      if ($effect == 'krovotechenie')
      {
        include_once ('modules/f_start_blood.php');
        start_blood ($name);
        return 1;
      }
      else if ($effect == 'otravlen')
      {
        include_once ('modules/f_start_poison.php');
        start_poison ($name);
        return 1;
      }
      else if ($effect == 'gorit')
      {
        include_once ('modules/f_start_fire.php');
        start_fire ($name);
        return 1;
      }

      $q = do_mysql ("SELECT affected FROM players WHERE id_player = '".$id."';");
      $a = mysql_result ($q, 0);
      if (is_in ($effect, $a))
      {
        $a = explode ('|', $a);
        $c = count ($a);
        for ($i = 0; $i < $c; $i++)
        {
          $a[$i] = explode (':', $a[$i]);
          if ($a[$i][0] == $effect) $a[$i][1] += $time;
          $a[$i] = $a[$i][0].':'.$a[$i][1];
        }
        $a = implode ('|', $a);
      }
      else
      {
        if (!$time) $time = (time() + $eff[$effect]);
        else $time = (time() + $time);
        $neff = $effect.':'.$time;
        if (is_in ('blagoslavlen', $a)) return 1;
        if (!$a) $a = $neff;
        else $a .= '|'.$neff;
      }
      do_mysql ("UPDATE players SET affected = '".$a."' WHERE id_player = '".$id."';");

      // dalee, esi estq takoj fail, spec izmenenija effekta ustanovim
      if (file_exists ('modules/effects/e_start_'.$effect.'.php'))
        include 'modules/effects/e_start_'.$effect.'.php';

      return 1;
    }
    else
    {
      $id = is_npc ($name);
      if (!$id) return 0;
      $q = do_mysql ("SELECT affected FROM npc WHERE id_npc = '".$id."';");
      $a = mysql_result ($q, 0);
      if (is_in ($effect, $a))
      {
        $a = explode ('|', $a);
        $c = count ($a);
        for ($i = 0; $i < $c; $i++)
        {
          $a[$i] = explode (':', $a[$i]);
          if ($a[$i][0] == $effect) $a[$i][1] += $time;
          $a[$i] = $a[$i][0].':'.$a[$i][1];
        }
        $a = implode ('|', $a);
      }
      else
      {
        if (!$time) $time = (time() + $eff[$effect]);
        else $time = (time() + $time);
        $neff = $effect.':'.$time;
        if (is_in ('blagoslavlen', $a)) return 1;
        if (!$a) $a = $neff;
        else $a .= '|'.$neff;
      }
      do_mysql ("UPDATE npc SET affected = '".$a."' WHERE id_npc = '".$id."';");
      return 1;
    }
  }
?>