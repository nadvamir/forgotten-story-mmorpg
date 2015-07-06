<?php
  $fd = fopen ('modules/posts/closed.txt', 'w');
  fwrite ($fd, '2');
  fclose ($fd);
  exit_msg ('доступ', 'всем, кто ниже админа, вход воспрешен.');
?>