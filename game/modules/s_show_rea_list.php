<?php
  // podatq zajavku v klan:
  if ($p['admin'] > 0)
  {
    $f = '<small>';
    include 'modules/items/items_m/items_m_rea.php';
    foreach ($it as $key => $value)
    {
      $value = explode ('|', $value);
      $f .= $value[0].' - '.$key.'<br/>';
    }
    $f .= '</small><a class="blue" href="game.php?sid='.$sid.'&action=generate_magic">генерация магии</a><br/>';
    exit_msg ('существующие реагенты', $f);
  }
?>