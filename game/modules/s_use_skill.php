<?php
  // skript ispolqzovanija navyka
  // prosto eshe raz proverjaet estq li etot fajl i togda vkljuchaet
  $skill = preg_replace ('/[^0-9]/', '', $_GET['skill']);
  if (file_exists ('modules/skills/sk_'.$skill.'.php') && $p['skills'][$skill] > 0) include 'modules/skills/sk_'.$skill.'.php';
  if (!isset ($WASBD)) $action = 'show_skills';
?>