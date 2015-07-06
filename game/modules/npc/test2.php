<?php
  // vysvetitq xml kod
  $file = file ("http://ws.darkagesworld.com/info.asmx/GetUserInfo?nick=Cuban");
  echo '<pre>';
  print_r ($file);
  echo '</pre>';
?>