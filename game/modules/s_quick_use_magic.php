<?php
  // bystroe ispolqzovanie veshej
  $num = preg_replace ('/[^0-9]/', '', $_GET['num']);
  if ($num === false) put_error ('a num gde?');
  if ($num > (count ($p['magic']))) $num = count ($p['magic']);
  if ($num <= 0) $num = 1;
  $num -= 1;
  $_GET['spell'] = $p['magic'][$num];
  $action = 'cast_from_head';
?>