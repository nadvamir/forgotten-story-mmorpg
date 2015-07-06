<?php
  // fail soderzhit zagruzochnuju infu karty
  // VESHI
  $items = array (
    'i.f.tra.podorozhnik' => 'i.f.tra.podorozhnik:rbfo|4x5~rbfo|6x5:1',
    'i.m.rea.pautina' => 'i.m.rea.pautina:rbfo|8x4~rbfo|7x1:1',
    'i.o.sta.rosarock' => 'i.o.sta.rosarock:rbfo|4x3:1',
    'i.o.sta.lake' => 'i.o.sta.lake:rbfo|3x3:1',
    'i.o.sta.runestone_vk2' => 'i.o.sta.runestone_vk2:rbfo|5x5:1',
    'i.o.sta.runestone_vk10' => 'i.o.sta.runestone_vk10:rbfo|7x1:1'
    );
  $npc = array (
    'n.a.mouse.1.m2' => 'n.a.mouse.1.m2::5',
    'n.a.rabbit.1.0' => 'n.a.rabbit.1.0:rbfo|4x5~rbfo|2x3~rbfo|1x6:3',
    'n.x.rabbit.1.2' => 'n.x.rabbit.1.2:rbfo|4x3~rbfo|5x3:2',
    'n.a.sinica.1.m2' => 'n.a.sinica.1.m2:rbfo|1x3~rbfo|3x6:1',
    'n.a.vorobej.1.m2' => 'n.a.vorobej.1.m2:rbfo|2x1~rbfo|2x3:1',
    'n.a.young_rabbit.1.m1' => 'n.a.young_rabbit.1.m1:rbfo|6x2~rbfo|5x5:1',
    'n.a.big_rabbit.1.1' => 'n.a.big_rabbit.1.1:rbfo|8x5:1',
    'n.a.old_rabbit.1.m1' => 'n.a.old_rabbit.1.m1:rbfo|8x2:1',
    'n.s.tuslik' => 'n.s.tuslik:rbfo|4x6:1',
    'n.a.utka.1.m1' => 'n.a.utka.1.m1:rbfo|3x3:1',
    'n.a.red_bird.3.1' => 'n.a.red_bird.3.1:rbfo|8x3:1',
    'n.x.witch.5.0' => 'n.x.witch.5.0:rbfo|5x1:1',
    'n.x.black_cat.4.1' => 'n.x.black_cat.4.1:rbfo|5x1:1'
    );
  // tekagi q: ninzja nochqju s 00 do 1h.
  $hour = get_hour ();
  $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE realname = 'n.s.hiroki';");
  $cnin = mysql_result ($q, 0);
  if ($hour < 1 && !$cnin)
  {
    // sozdaem hiroki
    include_once ('modules/f_create_npc.php');
    create_npc ('n.s.hiroki', 'rbfo', 'rbfo|1x6');
  }
  if ($hour > 0 && $cnin)
  {
    // udaljaem hiroki
    do_mysql ("DELETE FROM npc WHERE realname = 'n.s.hiroki';");
  }
?>