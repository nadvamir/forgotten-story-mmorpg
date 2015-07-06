<?php
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'просмотр BBкода', NOW());");
  $f = gen_header ('BBCode');
  $f .= '<div class="y" id="igAW"><b>BBCode</b></div><p>';
  $f .= 'это коды для замены хтмл тегов. транслит должен быть вырублен:<br/>';
  $f .= '[b]<b>жирный текст</b>[/b]<br/>';
  $f .= '[u]<u>подчеркнутый</u>[/u]<br/>';
  $f .= '[i]<i>наклонный</i>[/i]<br/>';
  $f .= '[url]<a class="blue" href="index.php">http://waprpg.freehostia.com</a>[/url]<br/>';
  $f .= '[br/]<br/>перенос';
  $f .= '<br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>