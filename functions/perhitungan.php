<?php
    function cmp($a, $b){
        if ($a == $b) {
            return 0;
        }
        return ($a[1] > $b[1]) ? -1 : 1;
    }