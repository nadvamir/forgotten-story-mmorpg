﻿<?php
  $f = gen_header ('Правила');
  $f .= '<div class="y" id="igAW"><b>Правила</b></div><p>';

  $f .= '<b>1</b> уголовная наказуемость и все такое.<br/>';
  $f .= 'Запрещено то что запрещено уголовным кодексов всех стран и народов, вообщем чего и напоминать - все то что нелзя нарушать вообще, нелзя нарушать и в виртуальном пространстве.<br/>';

  $f .= '<b>2</b> персонажи.<br/>';
  $f .= 'Мульты запрещены. Один игрок может иметь одного персонажа. Если хотите завести нового, сообщите прежде об этом на форуме - администрация удалит прежнего.<br/>';

  $f .= '<b>3</b> подарки судьбы.<br/>';
  $f .= 'Игра еще только в стадии бета тестирования, поэтому она может быть достаточно "щедра". Существуют два типа игровых ошибок - <br/>';
  $f .= '<b>жуки</b> (баги) - это обыкновенная ошибка в коде. Начиная самоубийством нпц, кончая блеванием артефактов зайцами. О всех этих ошибках игрок ОБЯЗАН сообщить на форуме в сответствующем отделе, ибо он является демо-тестером.<br/> ';
  $f .= 'А вот с <b>эксплойтами</b> (что по сути дела является просчетом разработчика) дело обстоит похуже. В принцыпе, это не ошибки. Но игра является достаточно большой, и сбалансировать ее одному человеку достаточно сложно. Поэтому, как демо-тестеры, вы обязаны сообщать хотя бы лично администрации о наличии просчетов, таких как сверх легкий способ заработать, или убить нпц, или... Администрация решит, оставить это так как есть, или принять меры.<br/>';

  $f .= '<b>4</b> мат и некультурное поведение на форуме.<br/>';
  $f .= 'первый раз бан. Второй раз блок с доступом лишь на этот самый форум, а если возникнут возмущения блок полный. Я грамотностью не страдаю, логикой тоже, посему я за чистый язык ^^<br/>';

  $f .= '<b>5</b> самосуд. <br/>';
  $f .= 'Пожалуйсто! За крысятничество, подлости вские да несоответствие игровому этикету игравая община вольна делать что хотит. Внутри игры вы вольны создавать свои законы, не противоречащие выше написаным.<br/>';

  $f .= '<b>6</b> наказания. <br/>';
  $f .= 'за мультов - блок всех на всегда, одному с доступом на форум в течении 15 дней, для ведения дискусий о своем существовании. Если компромиссов найдено не будет - и того в блок полный.';
  $f .= '<br/>за использование багов блок на 15 суток, возможны штрафы, и конфискация имузества в пользу государства.';

  $f .= '</p>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
  $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a>';
  $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>