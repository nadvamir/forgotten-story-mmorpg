<?php
  // osnavnaja funkcija lokacij
  function loc ($loc, $what, $del = 0)
  {
    //$what = preg_replace ('/[^a-z\._0-9]/i', '', $what);
    //$loc = preg_replace ('/[^a-z0-9\|]/i', '', $loc);
    // beret infu loki
    // esli what - near, to nada vsju infu i perehody
    // esli what = locinfo, to berem vsju infu konkretnoj lokacii;
    // esli what = temperatue, to berem temperaturu
    // berem infu i perehody
    // pervyj etap : chtenija karty s faila

    global $LOC;

    $loc = explode ('|', $loc);
    $l2 = $loc[1];
    //echo '<br/> l2 = '.$l2.'<br/>';
    $loc[1] = explode ('x', $loc[1]);
    if (!isset ($LOC[$loc[0]]))
    {
      // HALTURA, mozhet zaciklitsja tut
      if ( !make_namespace ($loc[0])) include 'modules/s_main.php';
    }
    $l = $LOC[$loc[0]];
    if (!$l[$l2])
    {
      echo $loc[0].'|'.$l2.' is bad <br/>';
      return 0;
    }
    //if (!isset($l[$l2])) put_error ('<p>нету такой локации: '.$loc[0].'|'.$l2.'</p>');
    //------------------------
    if ($what == 'near')
    {
      // teperq nado najti lokaciju igroka ($r[0]) i lokacii okruzhajushie ih
      $r[0] = explode ('~', $l[$l2]);
      // teperq algoritm koordinat okruzhenija ;)
      // snachala zapisyvajutsja vse vozmozhnye loki vokrug
      $a[1] = ($loc[1][0] - 1)."x".($loc[1][1] + 1);
      $a[2] = $loc[1][0]."x".($loc[1][1] + 1);
      $a[3] = ($loc[1][0] + 1)."x".($loc[1][1] + 1);
      $a[4] = ($loc[1][0] - 1)."x".$loc[1][1];
      $a[5] = ($loc[1][0] + 1)."x".$loc[1][1];
      $a[6] = ($loc[1][0] - 1)."x".($loc[1][1] - 1);
      $a[7] = $loc[1][0]."x".($loc[1][1] - 1);
      $a[8] = ($loc[1][0] + 1)."x".($loc[1][1] - 1);
      // teperq proverim kakie iz nih ukazany v faile
      // ukazano v r[0][4]
      // dlina stroki
      $len = strlen ($r[0][4]);
      for ($i = 0; $i < $len; $i++)
      {
        // v $r budet zapolnjatsja tolqko ukazanye tam
        // OBXJASNENIE V HELPE
        $r[$r[0][4][$i]] = explode ('~', $l[$a[$r[0][4][$i]]]);
      }
      if ($r[0][7])
      {
        // dobavljaem perehod na novuju lokaciju
        $ln = $r[0][7];
        $ln = explode (':', $ln);
        $r[$ln[1]] = loc ($ln[0], 'locinfo');
        $r[0][4] .= $ln[1];
      }
      return $r;
    }
    //--------
    if ($what == 'temperature')
    {
      $d = explode ('~', $l[$l2]);
      return $d[3];
    }
    if ($what == 'locinfo')
    {
      $d = explode ('~', $l[$l2]);
      return $d;
    }
  }

  function make_namespace ($lmap)
  {
    global $LOC;
    if (!isset ($LOC[$lmap]))
    {
      if (!file_exists('modules/loc/'.$lmap.'.php')) return 0;
      include ('modules/loc/'.$lmap.'.php');
      $LOC[$lmap] = $l;
      return 1;
    }
  }
?>