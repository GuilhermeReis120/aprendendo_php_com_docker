<?php
    $int = 10;
    $float = 10.5;
    $string = "Hello, World!";
    $bool = true;
    $array = [];
    if(is_int($int)) {
        echo "$int é um inteiro\n";
    }else {
        echo "$int não é um inteiro\n";
    }
    if(is_float($float)) {
        echo "$float é um float\n";
    }else {
        echo "$float não é um float\n";
    }
    if(is_string($string)) {
        echo "$string é uma string\n";
    }else {
        echo "$string não é uma string\n";
    }
    if(is_bool($bool)) {
        echo "$bool é um booleano\n";
    }else {
        echo "$bool não é um booleano\n";
    }
    if(is_array($array)) {
        echo "O array é um array\n";
    }else {
        echo "O array não é um array\n";
    }