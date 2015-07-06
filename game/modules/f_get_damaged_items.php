<?php
  // funkcija vozvrashjaet massiv veshej kotorye mozhno pochinitq
  function get_damaged_items ($login)
  {
    $di = array ();;
    $q = do_mysql ("SELECT fullname, str FROM items WHERE belongs = '".$login."' AND is_in LIKE 'w%' AND str < 1000;");
    while ($i = mysql_fetch_assoc ($q))
      $di[$i['fullname']] = $i['str'];
    $q = do_mysql ("SELECT fullname, str FROM items WHERE belongs = '".$login."' AND is_in LIKE 'a%' AND str < 1000;");
    while ($i = mysql_fetch_assoc ($q))
      $di[$i['fullname']] = $i['str'];
    $q = do_mysql ("SELECT fullname, str FROM items WHERE belongs = '".$login."' AND is_in LIKE 'shi' AND str < 1000;");
    while ($i = mysql_fetch_assoc ($q))
      $di[$i['fullname']] = $i['str'];
    return $di;
  }
?>