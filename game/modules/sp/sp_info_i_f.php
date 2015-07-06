<?php
  // vyvedenie informacii o veshjah: eda
  $f = gen_header ('инфо');
  $f .= '<div class="y" id="oaiyt">';
  $qitf = do_mysql ("SELECT * FROM items WHERE fullname = '".$to."';");
  $itf = mysql_fetch_assoc ($qitf);
  $itf['on_use'] = explode ('~', $itf['on_use']);
  $f .= '<b>'.$itf['name'].'</b></div><p>';
  if (substr ($to, 4, 3) == 'foo') $f .= 'еда<br/>';
  else if (substr ($to, 4, 3) == 'dri' && $itf['on_use'][0] < 0) $f .= 'яд<br/>';
  else if (substr ($to, 4, 3) == 'dri' && substr ($to, 8, 3) == 'bom') $f .= 'взрывчатое вещество<br/>';
  else if (substr ($to, 4, 3) == 'dri' && substr ($to, 8, 3) == 'alc') $f .= 'алкогольный напиток<br/>';
  else if (substr ($to, 4, 3) == 'dri') $f .= 'напиток<br/>';
  else if (substr ($to, 4, 3) == 'tra')
  {
    if (!$p['skills'][6])
    {
      $f .= 'трава<br/>';
      $f .= 'вес: '.$itf['weight'].'<br/>';
      $f .= 'цена: '.$itf['price'].'<br/>';
      $f .= '<a class="y" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a><br/>';
      if (isset ($_GET['npc']))
      {
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$_GET['npc'].'&start2='.$_GET['start2'].'&start='.$_GET['start'].'">торг</a><br/>';
      }
      $f .= '<a class="y" href="game.php?sid='.$sid.'">в игру</a></p>';
      $f .= gen_footer();
      exit ($f);
    }
    else
    {
      $f .= 'трава<br/>';
      $f .= '<b>'.$itf['on_drop'].'</b><br/>';
    }
  }
  $f .= '+'.$itf['on_use'][0].' к жизни<br/>';
  $f .= '+'.$itf['on_use'][1].' к мане<br/>';
  if ($itf['on_use'][2]) $f .= 'останавлевает кровотечение<br/>';
  if ($itf['on_use'][3]) $f .= 'противоядие<br/>';
  if ($itf['on_use'][4]) $f .= 'останавливает горение<br/>';
  $f .= 'вес: '.$itf['weight'].'<br/>';
  $f .= 'цена: '.$itf['price'].'<br/>';
  if ($itf['jewel'])
  {
    include_once ('modules/f_translit.php');
    $f .= 'эффект '.(translit ($itf['jewel'])).'<br/>';
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