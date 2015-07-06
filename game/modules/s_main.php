<?php
  // fail glavnoj stranicy
  // v zavisimosti ot nastroek
  ////////////////////////////////
  // GLAVNAJA INFA, 
  // lokacii okruzhajushie
//stime();
  if (!isset ($sid) || !$sid) // byvaet
  {
    $sid = $_GET['sid'];
    global $LOGIN;
  }
  $p = get_pl_info ($LOGIN, 'all');
  //if ($p['journal']) { include ('modules/s_journal.php'); }
  //include 'modules/s_sys_pl_temperature.php';
  include_once ('modules/f_loc.php');
  $loc = loc($p['location'], 'near');

  // nachalo stranicy, vverhu nazvanie
  $f = gen_header ($loc[0][1]);
  // status 
  if ($p['settings'][0] == 1) include 'modules/sp/sp_maininfo1.php';
  else include 'modules/sp/sp_maininfo0.php';
  // lokacija ili rezhim chata

  // soderzhanie lokacii
  include 'modules/sp/sp_sth_inloc.php';

  //unset ($JOURNAL);
  if ($p['settings'][1] == 1) include 'modules/sp/sp_locmode.php';
  if ($p['settings'][1] == 0) include 'modules/sp/sp_chatmode.php';
  $f .= gen_footer();
//etime('main');
  exit ($f);
?>
