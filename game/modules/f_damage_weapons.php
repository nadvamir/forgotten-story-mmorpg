<?php
  // funkcija portit oruzhija igrokov
  function damage_weapons ($login)
  {
    do_mysql ("UPDATE items SET str = str - 1 WHERE belongs = '".$login."' AND is_in = 'wea' AND str > 0;");
    $q = do_mysql ("SELECT fullname, str FROM items WHERE belongs = '".$login."' AND is_in = 'shi' AND type = 'w' AND str > 0;");
    if (mysql_num_rows ($q))
    {
      $it = mysql_fetch_assoc ($q);
      do_mysql ("UPDATE items SET str = str - 1 WHERE fullname = '".$it['fullname']."';");
    }
  }
?>