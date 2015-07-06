<?php
  // konstanty igry
  //---------------------------------------------------
  // inventarq:
  $I_WGH = 1;
  if ($p['settings'][5] == 1) $I_SEP_C = 29;
  if ($p['settings'][5] == 2) $I_SEP_C = 34;
  if ($p['settings'][5] == 3) $I_SEP_C = 39;
  if ($p['settings'][5] == 4)
  {
    $I_SEP_C = 34;
    $I_WGH = 0.75;
  }
  if ($p['settings'][5] == 5)
  {
    $I_SEP_C = 39;
    $I_WGH = 0.5;
  }

  $EXP_X = 1;
  $NOEFF = 0;
  $SIL_X = 1;
  $MIN_BET = 0;
  $MAX_MISC = 1000;

  if ($p['account'])
  {
    switch ($p['account'])
    {
      case 1:
        $I_SEP_C += 20;
        $SIL_X = 2;
        break;
      case 2:
        $I_SEP_C += 5;
        $EXP_X = 1.35;
        $NOEFF = 1;
        break;
      case 3:
        $MIN_BET = 1;
        $I_SEP_C += 20;
        break;
      case 4:
        $I_SEP_C += 20;
        $SIL_X = 2;
        $EXP_X = 1.35;
        $NOEFF = 1;
        $MIN_BET = 1;
        break;
    }
  }

  //--------------------------------------
  // proverka chela (vemja PEREDVIZHENIJA I vOOBSHE AKTIVNOSTI)
  // proverka na ataku v sootvetstvujushem faile, tut - proverka na regeneraciju i perehod

  // BAZOVOE VREMJA
  $T = 0;

  include_once ('modules/f_upd_affected.php');
  include_once ('modules/f_get_affected.php');
  upd_affected ($LOGIN);
  //if ($p['status1'][1] == 0) $T += 2;
  //if ($p['status1'][1] == 2) $T += 2;

  // effecty:
  $aff = get_affected ($LOGIN);
  $AFF = $aff; // dlja posledueshego ispolqzovanija
  if (is_in ('oglushen', $aff)) $T += 10;
  if (is_in ('zamerz', $aff)) $T += 10;
  if (is_in ('okamenel', $aff)) $T += 10;
  if (is_in ('odubel', $aff)) $T += 10;
  if (is_in ('paralizovan', $aff)) $T += 30;
  if (is_in ('zamedlen', $aff)) $I_WGH = 2;
  if (is_in ('udacha', $aff)) $MIN_BET = 1;
  // i tak dalee

  // prochnostq - 
  $I_P_P['fur'] = 1000;
  $I_P_P['tun'] = 1000;
  $I_P_P['bas'] = 1000;
  $I_P_P['nor'] = 1000;
  $I_P_P['bet'] = 1050;
  $I_P_P['rar'] = 1100;
  $I_P_P['eli'] = 1150;
  $I_P_P['epi'] = 1200;
  $I_P_P['leg'] = 1250;

  $I_P_J['agat'] = 1.1;
  $I_P_J['malahit'] = 1.2;
  $I_P_J['ametist'] = 1.3;

  // a tut konkretno vse kamni
  $I_J['agat']['str'] = $I_P_J['agat'];
  $I_J['agat']['dmg'] = 1.0;
  $I_J['agat']['arm'] = 1.0;
  $I_J['agat']['hp'] = 1.0;
  $I_J['malahit']['str'] = $I_P_J['malahit'];
  $I_J['malahit']['dmg'] = 1.0;
  $I_J['malahit']['arm'] = 1.0;
  $I_J['malahit']['hp'] = 1.0;
  $I_J['ametist']['str'] = $I_P_J['ametist'];
  $I_J['ametist']['dmg'] = 1.0;
  $I_J['ametist']['arm'] = 1.0;
  $I_J['ametist']['hp'] = 1.0;
  $I_J['izumrud']['str'] = 1.0;
  $I_J['izumrud']['dmg'] = 1.03;
  $I_J['izumrud']['arm'] = 1.03;
  $I_J['izumrud']['hp'] = 1.03;
  $I_J['sapfir']['str'] = 1.0;
  $I_J['sapfir']['dmg'] = 1.05;
  $I_J['sapfir']['arm'] = 1.05;
  $I_J['sapfir']['hp'] = 1.05;
  $I_J['rubin']['str'] = 1.0;
  $I_J['rubin']['dmg'] = 1.07;
  $I_J['rubin']['arm'] = 1.07;
  $I_J['rubin']['hp'] = 1.07;
  $I_J['almaz']['str'] = 1.0;
  $I_J['almaz']['dmg'] = 1.09;
  $I_J['almaz']['arm'] = 1.09;
  $I_J['almaz']['hp'] = 1.09;

  //-----------------------------------------------
  $NEWMAP = 0; // esli da, nado objazom loadmaps vkljuchitq, nesmotrja ni na chto
  //-----------------------------------------------

  // cveta konkretnoj lokacii, ukazyvajutsja v fajle, ili karty, tamzhe
  $COLOR;

  $LOC = array(); // lokacii

  $NPC_MOVED = array(); // npc chto perehodili na druguju loku

  $UND = 0; // na poverhnosti
?>