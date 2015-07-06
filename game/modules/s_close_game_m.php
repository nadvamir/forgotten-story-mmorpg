<?php
  $fd = fopen ('modules/posts/closed.txt', 'w');
  fwrite ($fd, '1');
  fclose ($fd);
  exit_msg ('доступ', 'всем, кто ниже модератора, вход воспрешен.');
?>