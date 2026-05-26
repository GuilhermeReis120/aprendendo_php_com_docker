<?php
// ─────────────────────────────────────────────────────
//  Página inicial do seu ambiente PHP
// ─────────────────────────────────────────────────────

$host = 'mysql';
$db   = 'meu_banco';
$user = 'usuario';
$pass = 'senha123';

// Testa conexão com o MySQL
$status_mysql = '❌ Sem conexão';
$cor_mysql    = '#e74c3c';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $status_mysql = '✅ Conectado com sucesso!';
    $cor_mysql    = '#27ae60';
} catch (PDOException $e) {
    $status_mysql = '❌ Erro: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐳 Meu Ambiente PHP Docker</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #1a1a2e;
            color: #eee;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container { max-width: 800px; width: 90%; }
        h1 { font-size: 2.5rem; margin-bottom: 0.3rem; }
        .subtitle { color: #aaa; margin-bottom: 2.5rem; }
        .card {
            background: #16213e;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.2rem;
            border-left: 4px solid #0f3460;
        }
        .card h2 { font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 0.8rem; }
        .status { font-size: 1.1rem; font-weight: 600; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .info-label { font-size: 0.8rem; color: #777; }
        .info-value { font-size: 1rem; font-weight: 500; margin-top: 2px; }
        .link-btn {
            display: inline-block;
            background: #0f3460;
            color: #fff;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .link-btn:hover { background: #533483; }
        .badge {
            display: inline-block;
            padding: 0.2rem 0.7rem;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #533483;
        }
        code {
            background: #0a0a1a;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #a8dadc;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🐳 Ambiente PHP</h1>
    <p class="subtitle">Seu servidor de desenvolvimento está funcionando!</p>

    <div class="card">
        <h2>🔌 Banco de Dados MySQL</h2>
        <p class="status" style="color: <?= $cor_mysql ?>"><?= $status_mysql ?></p>
    </div>

    <div class="card">
        <h2>🐘 Informações do PHP</h2>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Versão do PHP</div>
                <div class="info-value"><?= PHP_VERSION ?> <span class="badge">PHP <?= PHP_MAJOR_VERSION ?></span></div>
            </div>
            <div class="info-item">
                <div class="info-label">Sistema Operacional</div>
                <div class="info-value"><?= PHP_OS ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Servidor Web</div>
                <div class="info-value"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Fuso Horário</div>
                <div class="info-value"><?= date_default_timezone_get() ?></div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>🔗 Links Úteis</h2>
        <p style="margin-bottom: 1rem">
            <a class="link-btn" href="http://localhost:8081" target="_blank">📊 Abrir phpMyAdmin</a>
            <a class="link-btn" href="phpinfo.php">ℹ️ PHP Info</a>
            <!-- class="link-btn" href="/exemplos/crud.php" target="_blank">📒CRUD</> -->
            <a class="link-btn" href="1_intro/index.php">Introdução</a>
        </p>
        <p style="color: #888; font-size: 0.9rem">
            Banco de dados: <code><?= $db ?></code>
            Usuário: <code><?= $user ?></code>
        </p>
    </div>

    <div class="card">
        <h2>📁 Seus arquivos PHP</h2>
        <p style="color: #aaa; font-size: 0.95rem; line-height: 1.6">
            Coloque seus arquivos <code>.php</code> na pasta <code>www/</code> do projeto.<br>
            Eles ficam disponíveis em <code>http://localhost:8080/seu-arquivo.php</code>
        </p>
    </div>
</div>
</body>
</html>
