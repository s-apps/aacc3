<?php

    function getCargaHoraria($horas_inicio, $horas_termino){
        $explode1 = explode(':', $horas_inicio);
        $explode2 = explode(':', $horas_termino);
        $h1 = $explode1[0];
        $m1 = $explode1[1];
        $h2 = $explode2[0];
        $m2 = $explode2[1];
        $t1 = ($h1 * 60) + $m1;
        $t2 = ($h2 * 60) + $m2;
        $t3 = $t2 - $t1;
        $t4 = floor($t3/60);
        $t5 = $t3 - ($t4*60);
        return sprintf('%02d:%02d', $t4, $t5);
    }

    function getTotalHorasRealizadas($horas){
      $minutes = 0; //declare minutes either it gives Notice: Undefined variable
      // loop throught all the times
      foreach ($horas as $hora) {
          list($hour, $minute) = explode(':', $hora);
          $minutes += $hour * 60;
          $minutes += $minute;
      }
      $hours = floor($minutes / 60);
      $minutes -= $hours * 60;
      // returns the time already formatted
      return sprintf('%02d:%02d', $hours, $minutes);
    }

    function dentroDosLimitesDaModalidade($limitesDaModalidade, $carga_horaria){
        date_default_timezone_set('America/Sao_Paulo');
        $min_horas = strtotime($limitesDaModalidade['min_horas']);
        $max_horas = strtotime($limitesDaModalidade['max_horas']);
        $carga_horaria_total = strtotime($carga_horaria);
        if($carga_horaria_total > $max_horas || $carga_horaria_total < $min_horas){
            return false;
        }
        return true;
    }
