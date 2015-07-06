<?php
  // funkcija dlja dobavlenija effektov iz zaklinanija
  function mag_add_effects ($spell, $to)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$to = preg_replace ('/[^a-z0-9_\.]/i', '', $to);

    $q = do_mysql ("SELECT effect FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $eff = mysql_result ($q, 0);
    if (!$eff) return 0;

    // poka u magii tolqko odin effect mozhet bytq:
    // poetomu my prosto ego odnogo dobavim npc ili igroku funkciei set_affected
    include_once ('modules/f_set_affected.php');
    set_affected ($to, $eff);
    return 1;
  }
?>