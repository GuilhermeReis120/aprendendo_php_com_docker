 <?php
    echo "Conversor de temperaturas\n";
    echo "Opções:\n";
    echo "1 - Celsius\n";
    echo "2 - Fahrenheit\n";
    echo "3 - Kelvin\n";
    
    echo "Escolha a unidade de entrada (1, 2 ou 3): ";
    $unidade_entrada = trim(fgets(STDIN));
    echo "Digite a temperatura: ";
    $temperatura = trim(fgets(STDIN));
    echo "Escolha a unidade de para conversão (1, 2 ou 3): ";
    $unidade_saida = trim(fgets(STDIN));
    
    if ($unidade_entrada == $unidade_saida){
        echo "A temperatura é: $temperatura\n";
    }else{
        switch($unidade_entrada){
            case 1:
                if ($unidade_saida == 2){
                    $calc = ($temperatura * 9/5) + 32;
                    echo "A temperatura é: $calc\n";
                }
                if ($unidade_saida == 3){
                    $calc = $temperatura + 273.15;
                    echo "A temperatura é: $calc\n";
                }
                break;
            case 2:
                if ($unidade_saida == 1){
                    $calc = ($temperatura - 32) * 5/9;
                    echo "A temperatura é: $calc\n";
                }
                if ($unidade_saida == 3){
                    $calc = ($temperatura - 32) * 5/9 + 273.15;
                    echo "A temperatura é: $calc\n";
                }
                break;
            case 3:
                if ($unidade_saida == 1){
                    $calc = $temperatura - 273.15;
                    echo "A temperatura é: $calc\n";
                }
                if ($unidade_saida == 2){
                    $calc = ($temperatura - 273.15) * 9/5 + 32;
                    echo "A temperatura é: $calc\n";
                }
                break;
        }
    };
?>