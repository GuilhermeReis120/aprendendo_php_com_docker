<?php
    echo "Digite qual é o seu peso: ";
    $peso = floatval(fgets(STDIN));
    echo "Digite qual é a sua altura(em metros ex: 1.75): ";
    $altura = floatval(fgets(STDIN));
    $calc_imc = $peso / ($altura * $altura);
    echo "Seu IMC é: " . $calc_imc;
?>