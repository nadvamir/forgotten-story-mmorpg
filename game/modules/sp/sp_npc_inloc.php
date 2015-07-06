<?php
  // v lokacii estq npc:
        // npc
        include_once 'modules/f_get_npc_info.php';
        $name = get_npc_info ($inloc[$i], 'name');
        // zhiznq
        $life = get_npc_info ($inloc[$i], 'life');
        $life = explode ('|', $life);
        // - 
        switch (substr ($inloc[$i], 2, 1))
        {
          case 'a':
            $f .= '<span class="green"><b>.</b></span>';
            $bel = do_mysql ("SELECT belongs FROM npc WHERE fullname = '".$inloc[$i]."';");
            $bel = mysql_result ($bel, 0);
            if (!$bel)
              $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=priru&npc='.$inloc[$i].'">'.$name.'</a>';
            elseif ($bel == $LOGIN)
              $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=talk_to_priru&npc='.$inloc[$i].'">'.$name.'</a>';
            else
              $f .= $name;
            $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$inloc[$i].'">x</a>';
            break;
          case 'x':
            $f .= '<span class="red"><b>.</b></span>';
            $f .= $name;
            $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$inloc[$i].'">x</a>';
            break;
          case 's': case 't':
            $f .= '<b>.</b>';
            $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=speak_npc&npc='.$inloc[$i].'">'.$name.'</a>';
            break;
        }
        // dalee
        $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$inloc[$i].'">?</a>';
        // esli estq poterja zhizni - ukazhem ee kolichestvo v procentah
        if ($life[0] < $life[1]) $f .= ' ['.(round ($life[0] / $life[1] * 100)).'%]';
        // proverka boja
        $qb = do_mysql ("SELECT in_battle FROM npc WHERE fullname = '".$inloc[$i]."';");
        $nb = mysql_result ($qb, 0);
        if ($nb) $f .= '<в бою>';
        $f .= '<br/>';
?>