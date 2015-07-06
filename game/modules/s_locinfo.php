<?php
  // esli u svoej loki estq informacija to ee pokazhut
  $lcd = str_replace ('|', '_', $p['location']);
  if (isset ($_GET['loc']))
    $lcd = preg_replace ('/[^a-z_0-9]/i', '', $_GET['loc']);
  if (file_exists ('modules/loc_desc/'.$lcd.'.php'))
  {
    include_once 'modules/f_loc.php';
    $loci = loc ($p['location'], 'locinfo'); // infa loki
    include 'modules/loc_desc/'.$lcd.'.php'; //opisanie ee
    $f = gen_header ($loci[1]);
    $f .= '<div class="y" id="f1"><b>'.$loci[1].'</b></div>';
    $f .= '<p>';
    # dozhdq i drugie pogodnye javleniija potom
    switch ($loci[3])
    {
      case '-1': $f .= '<small>тут холодно</small><br/>'; break;
      case '0': break;
      case '1': $f .= '<small>тут жарко</small><br/>'; break;
    }
    switch ($loci[6])
    {
      case '1': $f .= '<small>помещение</small><br/>'; break;
      case '0': $f .= '<small>открытое пространство</small><br/>'; break;
    }
    $f .= $desc;
    if (isset ($_GET['loc'])) $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'&action=minimap">назад</a>';
    $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer();
    exit ($f);
  }
  else
  {
    put_error ('у етой локации нету описания');
  }
?>