<?php
  // magiei sozdatq veshq (melkih nelzja sozdovatq)
  // pered ispolqzovaniem proveritq klass dolzhen byt 'cre'
  function mag_it_create ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    $q = do_mysql ("SELECT cname FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $fullname = mysql_result ($q, 0);
    if (!$fullname) return 0;

    // sozdaem veshq:
    include_once ('modules/f_gain_item.php');
    // eta funkcija sama i sozdast
    gain_item ($fullname, 1, $login);

    return 1;
  }
?>