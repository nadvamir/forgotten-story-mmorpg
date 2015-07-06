<?php
  $f = gen_sheader ('Warriors Legend');
  $f .= '<div class="y" id="saidlhg"><b>Warriors Legend</b></div><div class="n" id="lfsi">';

  //-----------------------------------------------------------
  // include
  $W = file ('in.txt');
  $cW = count ($W);
  for ($i = 0; $i < $cW; $i++) $W[$i] = explode ('|', $W[$i]);
  $C = file ('in2.txt');
  $cC = count ($C);
  for ($i = 0; $i < $cC; $i++) $C[$i] = explode ('|', $C[$i]);

  //-----------------------------------------------------------
  // calculations:
  if (isset ($_GET['mw0']))
  {
    $mw = array(); $mc = array(); $ow = array(); $oc = array();
    for ($i = 0; $i < $cW; $i++) $mw[$i] = preg_replace ('/[^0-9]/', '', $_GET['mw'.$i]);
    for ($i = 0; $i < $cC; $i++) $mc[$i] = preg_replace ('/[^0-9]/', '', $_GET['mc'.$i]);
    for ($i = 0; $i < $cW; $i++) $ow[$i] = preg_replace ('/[^0-9]/', '', $_GET['ow'.$i]);
    for ($i = 0; $i < $cC; $i++) $oc[$i] = preg_replace ('/[^0-9]/', '', $_GET['oc'.$i]);
  }

  //-----------------------------------------------------------
  // form
  $f .= '<form action="index.php" method="get">';
  $f .= '<table><tr><td><b>Your</b></td></tr><tr><td><u>army</u></td></tr>';
  for ($i = 0; $i < $cW; $i++)
    $f .= '<tr><td>'.$W[$i][0].'</td><td><input type="text" name = "mw'.$i.'" value="'.((isset ($mw[$i]) && $mw[$i]) ? $mw[$i][0] : 0).'"/></td></tr>';
  $f .= '<tr><td><u>city</u></td></tr>';
  for ($i = 0; $i < $cC; $i++)
    $f .= '<tr><td>'.$C[$i][0].'</td><td><input type="text" name = "mc'.$i.'" value="'.((isset ($mc[$i]) && $mc[$i]) ? $mc[$i][0] : 0).'"/></td></tr>';

  $f .= '<tr><td><b>Opponents</b></td></tr><tr><td><u>army</u></td></tr>';
  for ($i = 0; $i < $cW; $i++)
    $f .= '<tr><td>'.$W[$i][0].'</td><td><input type="text" name = "ow'.$i.'" value="'.((isset ($ow[$i]) && $ow[$i]) ? $ow[$i][0] : 0).'"/></td></tr>';
  $f .= '<tr><td><u>city</u></td></tr>';
  for ($i = 0; $i < $cC; $i++)
    $f .= '<tr><td>'.$C[$i][0].'</td><td><input type="text" name = "oc'.$i.'" value="'.((isset ($oc[$i]) && $oc[$i]) ? $oc[$i][0] : 0).'"/></td></tr>';
  $f .= '<tr><td><input type="submit" value="CALC!"/></td></tr>';

  $f .= '</table></form>';
  //------------------------------------------------------------

  $f .= '</body></html>';
  exit ($f);

  //------------------------------------------------------------


  function gen_sheader($title)
  {
    ######## bez funkcij #############
    // sozdaet zagolovok
    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">';
    $header .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">';
    $header .= '<head><title>'.$title.'</title>';
    $header .= "<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=utf-8' />";
    $header .= '<meta name="verify-v1" content="WYU52LQMeGE90SGhlyABDtOm4Acxep20XoCyk+UWzwU=" />';
    $header .= '<meta http-equiv="cache-control" content="no-cache" />';
    $header .= '<meta http-equiv="pragma" content="no-cache" />';
    $header  .= '<meta name="copyright" content="&copy; 2008 Maksim Solovjov" />';
    //--
    $header .= '<style type="text/css">';
    $header .= 'body{}';
    $header .= 'a.black{color:#000000}';
    $header .= 'a.red{color:#ff0000}';
    $header .= 'a.blue{color:#0000ff}';
    #$header .= 'body{background-color:#ffff00;}';
    $header .= 'input{background-color:#ffffff;}';
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $wdt = '';

    $header .= 'div.y{background-color:#ffe13a; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #fdf274; border-top:1px solid #fdf274; border-right:2px solid #ffd33a; border-bottom:2px solid #ffd33a; font-size:small}';
    $header .= 'div.p{text-align:left;'.$wdt.' background-color: #FFFACD}';
    $header .= 'div.n{text-align:left;'.$wdt.' background-color:#f9fcfc; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #f9fcfc; border-top:1px solid #f9fcfc; border-right:2px solid #f1fdfd; border-bottom:2px solid #f1fdfd; font-size:small}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{text-align:left;'.$wdt.' background-color:#f9fcfc; margin: 0px; padding:2px 2px 2px 2px; border-left:1px solid #f9fcfc; border-top:1px solid #f9fcfc; border-right:2px solid #f1fdfd; border-bottom:2px solid #f1fdfd; font-size:small}';
    $header .= '</style>';
    //--
    $header .= '</head><body>';
    return $header;
  }
?>