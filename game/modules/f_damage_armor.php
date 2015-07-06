<?php
  // funkcija portit bronju, i esli nada to wit
  function damage_armor ($login, $shield = 0)
  {
    do_mysql ("UPDATE items SET str = str - 1 WHERE belongs = '".$login."' AND is_in LIKE 'a%' AND str > 0;");
    if ($shield) do_mysql ("UPDATE items SET str = str - 1 WHERE belongs = '".$login."' AND is_in = 'shi' AND str > 0;");
  }
?>