<?php
  // v lokacii nahoditsja veshq
        // veshq mozhet bytq tolqko dvuh tipov, nuzhnyh nam tut
        // ta kotoruju vzjatq nelzja, i ta kotoruju mozhno
        //esli vzjatq nelzja
        if (substr ($inloc[$i], 2, 1) == 'o' || substr ($inloc[$i], 2, 1) == 'l') // posle svitkov svobodnoj s netu, poetomu stojashjaja veshq u nas o nazyvaetsja. o tak ot )
        {
          // nepodvizhnaja veshq
          include_once ('modules/f_get_it_name.php');
          $name = get_it_name ($inloc[$i]);
          $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$inloc[$i].'">';
          $f .= $name.'</a> <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$inloc[$i].'">?</a><br/>';
        }
        elseif (substr ($inloc[$i], 2, 1) == 'm') // melkaja
        {
          // melkaja veshq veshq
          include_once ('modules/f_get_it_name.php');
          $name = get_it_name ($inloc[$i]);
          $count = do_mysql("SELECT on_take FROM items WHERE fullname = '".$inloc[$i]."';");
          $count = mysql_result ($count, 0);
          $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_misc1&item='.$inloc[$i].'">';
          $f .= $name.'</a> ('.$count.') <a class="blue" href="game.php?sid='.$sid.'&action=take_misc2&item='.$inloc[$i].'&count=1000">*</a> <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$inloc[$i].'">?</a><br/>';
        }
        else
        {
          // znacit veshq mozhno podnjatq
          // tak i sdelaem etu ssylku
          include_once ('modules/f_get_it_name.php');
          $name = get_it_name ($inloc[$i]);
          $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_item&item='.$inloc[$i].'">';
          $f .= $name.'</a> <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$inloc[$i].'">?</a><br/>';
        }
?>