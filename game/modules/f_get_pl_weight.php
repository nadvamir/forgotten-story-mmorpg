<?php
  // vzjatq ves vseh veshej igroka:
  function get_pl_weight ($login)
  {
    //$login = mysql_real_escape_string ($login);
    //if (!is_player ($login)) put_error ('this function sums weight for players');

    $q = do_mysql ("SELECT SUM(weight) FROM items WHERE belongs = '".$login."' AND is_in <> 'ban';");
    $wgh = mysql_fetch_assoc ($q);
    if (!$wgh['SUM(weight)']) $wgh['SUM(weight)'] = 0;
    global $I_WGH;
    $wgh['SUM(weight)'] = round ($wgh['SUM(weight)'] * $I_WGH);
    return $wgh['SUM(weight)'];
  }
?>