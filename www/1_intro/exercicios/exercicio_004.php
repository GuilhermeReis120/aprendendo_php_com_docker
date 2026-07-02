<?php
    $a = 10; $b = 20; $c = 30;
    if(is_numeric($a)){
        $calc = $a + $b * $c;
        if ($calc > 100){
            echo "O resultado é maior que 100\n";
        } else {
            echo "O resultado é menor que 100\n";
        }
    }
?>