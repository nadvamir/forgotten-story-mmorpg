﻿<?php
  if ($p['qlvl'] == 1 && $p['classof'] == 0) $spf['start'] = 'Ну что странник, дворец ищешь? Да вот он, за моей спиной. Только я тебя туда непущу, у тебя паспорта нет.|passport~усы да хвост - вот мой паспорт!';
  elseif ($p['qlvl'] == 1 && $p['classof'] != 0 && $part == 'II')
  {
    include_once ('modules/f_next_q.php');
    next_q ();
    include_once ('modules/f_gain_peace_exp.php');
    gain_peace_exp (50, $LOGIN);
  }
  elseif ($p['qlvl'] == 1 && $p['classof'] != 0) $spf['start'] = 'А ты смотрю уже и класс выбрал? Ну как, соовсем тебя замучали наверно?|na~да ну их ... !';
  else  $spf['start'] = 'Мое тебе, '.$LOGIN.', приветствие! Проходи тут почаще, ато сам понимаешь, скучно одному здесь днями торчать...';
  $spf['passport'] = '[перекрестился] Згинь, нечисть! А, показалось, нет у тебя хвоста даже. Вообшем, про паспорт - это шутка была. Я имел ввиду просто ты неопределенного класса. Все прописаные в этом городе жители причислены к какому-нибудь классу. Тоесть они либо воины либо маги либо лучники. Так в армии ими управлять легче. Ну а ты видимо прохожий и поэтому нелзя тебе к Лорду.|toldme~да мне сказали, что этот самый лорд мне и выдаст класс!';
  $spf['toldme'] = 'Да кто тебе это сказал? Лорд только выдает граммоту. А класс ты выбераешь сам. Сходи к Роттену или к Робине или к Велдиру, они тебе все пояснят. А пока в дворец тебе ни шагу нелзя, дружище ;)';
  $spf['na'] = 'Хexe, да пойми, скучно народу с тех пор как мост закрыли. Вот и издеваются над новичками, уже что попросить придумать немогут, вот и просят всякую дребедень. Хотя указ был, принимать всех Новопришедших )|na2~да? да ну их ...!';
  $spf['na2'] = 'Хех, походу перестарался народ. Ладно, дружище, иди в дворец, там сразу к Лорду, он тебе грамоту даст, и кончатся твой кошачьи дни...|II~[глава II]';
  
?>