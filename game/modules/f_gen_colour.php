<?php
  // funkcija vozvrashjaet cvet layera i fona v obshem
  function gen_colour ()
  {
    $month = get_month();
    $hour = get_hour();
    /*$weather = do_mysql ("SELECT weather FROM maps;");
    $weather = mysql_result ($weather, 0);*/
    switch ($month)
    {
      case 1: include 'modules/sp/sp_colour_1.php'; break;
      case 2: include 'modules/sp/sp_colour_2.php'; break;
      case 3: include 'modules/sp/sp_colour_3.php'; break;
      case 4: include 'modules/sp/sp_colour_4.php'; break;
      case 5: include 'modules/sp/sp_colour_5.php'; break;
      case 6: include 'modules/sp/sp_colour_6.php'; break;
      case 7: include 'modules/sp/sp_colour_7.php'; break;
      case 8: include 'modules/sp/sp_colour_8.php'; break;
      case 9: include 'modules/sp/sp_colour_9.php'; break;
      case 10: include 'modules/sp/sp_colour_10.php'; break;
      case 11: include 'modules/sp/sp_colour_11.php'; break;
      case 12: include 'modules/sp/sp_colour_12.php'; break;
    }
/*
//unset ($NIGHT);
//$NIGHT = 1;
//unset ($MORNING);
//$MORNING = 1;
//unset ($DAY);
//$DAY = 1;
    global $UND;
    if ($UND) $NIGHT = 1;
    $colour[6] = '#000000'; // osnovnoj tekst
    $colour[7] = '#0000aa'; // sinie ssylki
    $colour[8] = '#ff0000'; // krasnye ssylki
    if (isset ($NIGHT))
    {
      //$colour[3] = '#B5B5B5'; // main for <p>
      //$colour[4] = '#CFCFCF'; // fair
      //$colour[5] = '#9C9C9C'; // dark
      
      $colour[3] = '#2a2a40'; // main for <p>
      $colour[4] = '#44444a'; // fair
      $colour[5] = '#000000'; // dark
      $colour[6] = '#DEDEF1'; // osnovnoj tekst
      $colour[7] = '#EBE916'; // "sinie" ssylki
      $colour[8] = '#ff0000'; // "krasnye" ssylki
    }
    else if (isset ($MORNING))
    {
      $colour[3] = '#fef6f8'; // main for <p>
      $colour[4] = '#fef1f4'; // fair
      $colour[5] = '#feecf1'; // dark
    }
    else if (isset ($DAY))
    {
      $colour[3] = '#FDFBF0'; // main for <p>
      $colour[4] = '#FFFFFB'; // fair
      $colour[5] = '#FDFAD9'; // dark
    }
    else
    {
      //$colour[3] = '#f9eac1'; // main for <p>
      //$colour[4] = '#faf0d5'; // fair
      //$colour[5] = '#fee5a2'; // dark
      $colour[3] = '#f9eac1'; // main for <p>
      $colour[4] = '#faf0d5'; // fair
      $colour[5] = '#fee5a2'; // dark
      $colour[6] = '#000000'; // osnovnoj tekst
      $colour[7] = '#0000aa'; // sinie ssylki
      $colour[8] = '#ff0000'; // krasnye ssylki
    }*/
    $colour[3] = '#FDFBF0'; // main for <p>
    $colour[4] = '#FFFFFB'; // fair
    $colour[5] = '#FDFAD9'; // dark
    $colour[6] = '#000000'; // osnovnoj tekst
    $colour[7] = '#0000aa'; // sinie ssylki
    $colour[8] = '#ff0000'; // krasnye ssylki
    return $colour;
  }
?>