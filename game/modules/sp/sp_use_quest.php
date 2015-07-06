<?php
  // pozvoljaet ispolqzovatq nepodvizhnuju veshq
  // u kazhdoj nepodvizhnoj veshi estq svoj fail,
  // takchto tut tolqko ego ustanovim i podkljuchim
  // proverka estq li v lokacii
  // nazvanie faila:
  include_once ('modules/f_real_name.php');
  $rn = real_name ($item);
  $rn = str_replace ('.', '_', $rn);
  $file_name = 'modules/uq_quest/uq_'.$rn.'.php';
  // podkljuchaem esli estq
  if (file_exists($file_name))
  {
    include ($file_name);
    include 'modules/s_main.php';
  }
  else
  $f = 'никакого эффекта';
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 2;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>