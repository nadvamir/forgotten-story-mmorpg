<?php
  // bystroe ispolqzovanie veshej
  $num = preg_replace ('/[^0-9]/', '', $_GET['num']);
  if ($num === false) put_error ('a num gde?');
  if ($num > (count ($p['kombo']))) $num = count ($p['kombo']);
  if ($num <= 0) $num = 1;
  $num -= 1;
  $_GET['kombo'] = $p['kombo'][$num];
  $action = 'use_kombo';
?>