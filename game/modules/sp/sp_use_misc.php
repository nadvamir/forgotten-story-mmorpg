<?php
  $f = 'никакого эффекта';
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 2;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>