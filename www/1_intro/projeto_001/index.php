<?php
echo "Olá, mundo! Este é o ambiente de desenvolvimento PHP funcionando perfeitamente.";
echo "<br>Versão do PHP: " . PHP_VERSION;
echo "<br>Servidor Web: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Apache'); 
?>  