<?php
  // funkcija vozvrashjaet maksimalqnuju prochnostq veshi
  function get_max_str ($item)
  {
    global $I_P_P;
    global $I_P_J;
    $pref = substr ($item, 8, 3);
    $q = do_mysql ("SELECT jewel FROM items WHERE fullname = '".$item."';");
    if (!mysql_num_rows ($q)) put_error ('вешь не существует: '.$item);
    $jewel = mysql_result ($q, 0);
    $str = $I_P_P[$pref];
    if (isset ($I_P_J[$jewel])) $str = round ($str * $I_P_J[$jewel]);

    //$q = do_mysql ("SELECT maxduraminus FROM items WHERE fullname = '".$item."';");
    //$mdm = mysql_result ($q, 0);
    //$str -= $mdm;
    return ($str);
  }
?>