<?php
  // infa broni
  $f = gen_header ('инфо');
  $f .= '<div class="y" id="oaiyt">';
  $qitf = do_mysql ("SELECT * FROM items WHERE fullname = '".$to."';");
  $itf = mysql_fetch_assoc ($qitf);
  $qua = substr ($to, 8, 3);
  $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
  if (strpos ($qlist, $qua) === false) $qua = 'black';
  $f .= '<b><span class="'.$qua.'">'.$itf['name'].'</span></b></div><p>';
  $f .= 'щит<br/>';
  $arm = explode ('~', $itf['armor']);
  $f .= '<b>защита:</b> <br/>';
  $f .= 'режущий: '.$arm[0].'<br/>';
  $f .= 'колющий: '.$arm[1].'<br/>';
  $f .= 'дробяший: '.$arm[2].'<br/>';
  $f .= 'рубящий: '.$arm[3].'<br/>';
  $f .= 'c~л~и~р: '.$itf['on_take'].'<br/>';
  $f .= 'вес: '.$itf['weight'].'<br/>';
  $f .= 'цена: '.$itf['price'].'<br/>';
  $f .= 'целостность: '.$itf['str'].'<br/>';
  if ($itf['jewel'])
  {
    include_once ('modules/f_translit.php');
    $f .= 'инкрустирован '.(translit ($itf['jewel'])).'<br/>';
  }
  $if = str_replace ('.', '_', $itf['realname']); 
  if (file_exists ('modules/info/items/i_'.$if.'.txt'))
  {
    $f .= file_get_contents ('modules/info/items/i_'.$if.'.txt');
    $f .= '<br/>';
  }
  $f .= '<a class="y" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a><br/>';
  if (isset ($_GET['npc']))
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$_GET['npc'].'&start2='.$_GET['start2'].'&start='.$_GET['start'].'">торг</a><br/>';
  }
  if (isset ($_GET['type']))
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=market&type='.$_GET['type'].'&start='.$_GET['start'].'">назад</a><br/>';
  }
  $f .= '<a class="y" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>