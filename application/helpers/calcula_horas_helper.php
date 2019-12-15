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