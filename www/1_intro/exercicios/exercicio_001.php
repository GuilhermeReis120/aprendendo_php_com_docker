<?php
    echo "Hello, World!\n";
    $n1_idade = 18;
    $n2_idade = 33;
    $n3_idade = 22;

    if($n1_idade > $n2_idade && $n1_idade > $n3_idade) {
        echo "A maior idade é: $n1_idade\n";
    } else if($n2_idade > $n1_idade && $n2_idade > $n3_idade) {
        echo "A maior idade é: $n2_idade\n";
    } else {
        echo "A maior idade é: $n3_idade\n";
    }