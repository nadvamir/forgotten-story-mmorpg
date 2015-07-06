<?php
  // fail ispolqzovanija veshej
  // tolqko perebiraet tipy i podkljuchjaet drgie nuzhnye faily
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $t = substr ($item, 2, 1);
  include_once 'modules/f_has_item.php';
  include_once 'modules/f_get_it_name.php';
  $itname = get_it_name ($item);
  // infa veshi
  //$ii = get_it_info ($item);
  if (has_item ($item, $LOGIN) == 0) put_g_error ('у вас нету этой веши');
  // handler )
  // stranica
  switch ($t) // eti ne trebujut novoj stranicy
  {
    case 'w': include 'modules/sp/sp_use_weapon.php'; break;
    case 'a': include 'modules/sp/sp_use_armor.php'; break;
    case 'f': include 'modules/sp/sp_use_food.php'; break;
    case 's': include 'modules/sp/sp_use_scroll.php'; break;
    case 'b': include 'modules/sp/sp_use_book.php'; break;
    case 'm': include 'modules/sp/sp_use_misc.php'; break;
    case 'q': include 'modules/sp/sp_use_quest.php'; break;
    case 'x': include 'modules/sp/sp_use_shield.php'; break;
  }
  $f = gen_header ('инвентарь');
  $f .= '<div class="y" id="gasi"><b>инвентарь:</b></div><p>';
  switch ($t) // eti trebujut
  {
    case 's': include 'modules/sp/sp_use_scroll.php'; break;
    case 'b': include 'modules/sp/sp_use_book.php'; break;
  }
  if (!isset ($_GET['to']) && $t != 'q')
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer();
    exit ($f);
  }
?>