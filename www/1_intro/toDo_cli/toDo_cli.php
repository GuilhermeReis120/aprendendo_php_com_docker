<?php
echo "Hello, World!";
echo "==============================\n";
echo "Bem-vindo ao ToDo CLI!\n";
echo "==============================\n";
echo "Digite 'help' para ver os comandos disponíveis.\n";
$tasks = [];
while (true) {
    echo "\n> ";
    $input = trim(fgets(STDIN));
    $command = explode(' ', $input)[0];

    switch ($command) {
        case 'add':
            $task = substr($input, 4);
            if (!empty($task)) {
                $tasks[] = $task;
                echo "Tarefa adicionada: $task\n";
            } else {
                echo "Por favor, forneça uma tarefa para adicionar.\n";
            }
            break;
        case 'list':
            if (empty($tasks)) {
                echo "Nenhuma tarefa encontrada.\n";
            } else {
                echo "Tarefas:\n";
                foreach ($tasks as $index => $task) {
                    echo ($index + 1) . ". $task\n";
                }
            }
            break;
        case 'help':
            echo "Comandos disponíveis:\n";
            echo "add [tarefa] - Adiciona uma nova tarefa\n";
            echo "list - Lista todas as tarefas\n";
            echo "exit - Encerra o programa\n";
            break;
        case 'exit':
            echo "Encerrando o ToDo CLI. Até mais!\n";
            exit(0);
        default:
            echo "Comando desconhecido. Digite 'help' para ver os comandos disponíveis.\n";
    }
}