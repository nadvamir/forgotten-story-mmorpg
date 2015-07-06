<?php
  // podatq zajavku v klan:
  if (!$p['clan'][0])
  {
    // tolqko bezklanovym
    // rassmotrim zapros:
    $clan = preg_replace ('/[^a-z0-9_]/i', '', $_GET['clan_name']);
    $q = do_mysql ("SELECT newcomers FROM clans WHERE clanname = '".$clan."';");
    if (!mysql_num_rows ($q)) put_g_error ('такого клана не существует!');
    $ncm = mysql_result ($q, 0);
    $ncma = explode ('|', $ncm);
    if (in_array ($LOGIN, $ncma)) put_g_error ('вы уже подали заявку на этот клан');
    // dobavljaem:
    if (!$ncm) $ncm = $LOGIN;
    else $ncm .= '|'.$LOGIN;
    do_mysql ("UPDATE clans SET newcomers = '".$ncm."' WHERE clanname = '".$clan."';");
    exit_msg ('заявка', 'ваша заявка принята на рассмотрение');
  }
?>