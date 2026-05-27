<?php

echo "Bem-vindo à calculadora CLI!\n";
echo "Digite um número: ";
$numero1 = trim(fgets(STDIN));
echo "Digite a operação (+, -, *, /):";
$operacao = trim(fgets(STDIN));
echo "Digite outro número:";
$numero2 = trim(fgets(STDIN));
$resultado = 0;
switch ($operacao) {
    case '+':
        $resultado = $numero1 + $numero2;
        break;
    case '-':
        $resultado = $numero1 - $numero2;
        break;
    case '*':
        $resultado = $numero1 * $numero2;
        break;
    case '/':
        if ($numero2 != 0) {
            $resultado = $numero1 / $numero2;
        } else {
            echo "Erro: Divisão por zero!";
            exit(1);
        }
        break;
    default:
        echo "Operação inválida!\n";
        exit(1);
}
echo "O resultado é: " . $resultado . "\n";