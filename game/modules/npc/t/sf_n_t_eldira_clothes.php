﻿<?php
  $spf['start'] = 'Здравствуй! Я думаю, тебе уже пора одежду сменить, знаешь, мода быстро меняется. Тулупы от Версаче, валенки от Гуччи, бурачки от Лореаль - что еще нужно проффесанальному воину?|ask_to_learn~Это всё мощно, не спорю, но я и сам в глубине души модельер. Ну, где-то там, глубоко. Можешь показать, как шить одежду?';
  $spf['ask_to_learn'] = 'Да? Неожидала я от тебя такого… Впрочем… Я могу тебе показать, как шьют модные меховые шубки, но это денег стоит. Монет так 1000, не меньше. А если ты не при деньгах, то придётся методом научного тыка. Можешь попробовать к стати, вот тут столик не по далёку, и решить, надо ли тебе, или не надо. Только смотри мне, свои шкуры да меха порть!|learn1000~что-ж, держи деньги|ask900~нет, ну ты издеваешься что-ли? У кузнеца ковать научится дешевле.|gopractise~ладно, пойду, попробую';
  $spf['ask900'] = 'Тут тонкость нжна, навык! Хотя, я наверно загнула. 800, и не меньше!|learn800~вот, другое дело. Держи серебро!|gopractise~э, нет, 500 красная цена этому навыку.';
  $spf['gopractise'] = 'Вот пойди, пойди и попробуй сам что-то сшить. Как палец проколишь — передумаешь!';
  if ($part == 'learn1000')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (42, 1000);
  }
  if ($part == 'learn800')
  {
    include_once ('modules/f_learn_skill.php');
    learn_skill (42, 800);
  }
?>