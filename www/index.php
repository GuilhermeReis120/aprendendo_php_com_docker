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
$class_mysql  = 'danger';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $status_mysql = '✅ Conectado com sucesso!';
    $cor_mysql    = '#27ae60';
    $class_mysql  = 'success';
} catch (PDOException $e) {
    $status_mysql = '❌ Erro: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐳 PHP Docker Environment</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --php-color: #777bb4;
            --docker-color: #2496ed;
            --mysql-color: #00758f;
            --light-bg: #f8f9fa;
            --card-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: var(--docker-color) #e9ecef;
        }

        *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        *::-webkit-scrollbar-track {
            background: #e9ecef;
        }

        *::-webkit-scrollbar-thumb {
            background: var(--docker-color);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: #0d6efd;
        }

        html, body {
            height: 100%;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
            border-bottom: 2px solid #e9ecef;
            box-shadow: var(--card-shadow);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: #6c757d !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--php-color) !important;
        }

        .hero-section {
            padding: 4rem 2rem 2rem;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section .lead {
            color: #6c757d;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0.5rem;
        }

        .status-badge.connected {
            background: rgba(39, 174, 96, 0.15);
            color: #27ae60;
            border: 1px solid rgba(39, 174, 96, 0.3);
        }

        .status-badge.disconnected {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            border-left: 4px solid #e9ecef;
            margin-bottom: 2rem;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .card.php-card {
            border-left-color: var(--php-color);
        }

        .card.php-card:hover {
            background: rgba(119, 123, 180, 0.02);
        }

        .card.docker-card {
            border-left-color: var(--docker-color);
        }

        .card.docker-card:hover {
            background: rgba(36, 150, 237, 0.02);
        }

        .card.mysql-card {
            border-left-color: var(--mysql-color);
        }

        .card.mysql-card:hover {
            background: rgba(0, 117, 143, 0.02);
        }

        .card-header-custom {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #e9ecef;
        }

        .card-header-custom h5 {
            margin: 0;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .card-header-custom.php-header {
            border-bottom-color: rgba(119, 123, 180, 0.2);
        }

        .card-header-custom.php-header h5 {
            color: var(--php-color);
        }

        .card-header-custom.docker-header {
            border-bottom-color: rgba(36, 150, 237, 0.2);
        }

        .card-header-custom.docker-header h5 {
            color: var(--docker-color);
        }

        .card-header-custom.mysql-header {
            border-bottom-color: rgba(0, 117, 143, 0.2);
        }

        .card-header-custom.mysql-header h5 {
            color: var(--mysql-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .info-item {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #e9ecef;
        }

        .info-item:hover {
            background: #e9ecef;
        }

        .info-label {
            font-size: 0.85rem;
            color: #95a5a6;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value code {
            background: #ecf0f1;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            color: var(--php-color);
            font-size: 0.9rem;
        }

        .btn-custom {
            font-weight: 600;
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-php {
            background: linear-gradient(135deg, var(--php-color) 0%, #5b63a0 100%);
            color: white;
        }

        .btn-php:hover {
            background: linear-gradient(135deg, #5b63a0 0%, var(--php-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(119, 123, 180, 0.3);
        }

        .btn-docker {
            background: linear-gradient(135deg, var(--docker-color) 0%, #0d47a1 100%);
            color: white;
        }

        .btn-docker:hover {
            background: linear-gradient(135deg, #0d47a1 0%, var(--docker-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(36, 150, 237, 0.3);
        }

        .btn-secondary-custom {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .btn-secondary-custom:hover {
            background: #bdc3c7;
            color: #2c3e50;
        }

        .badge-custom {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }

        .badge-php {
            background: rgba(119, 123, 180, 0.15);
            color: var(--php-color);
            border: 1px solid rgba(119, 123, 180, 0.3);
        }

        .badge-docker {
            background: rgba(36, 150, 237, 0.15);
            color: var(--docker-color);
            border: 1px solid rgba(36, 150, 237, 0.3);
        }

        .alert-custom {
            border: none;
            border-radius: 12px;
            border-left: 4px solid #e9ecef;
        }

        .alert-custom.alert-info {
            background: rgba(13, 110, 253, 0.08);
            border-left-color: #0d6efd;
            color: #004085;
        }

        code {
            background: #ecf0f1;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            color: #e74c3c;
            font-size: 0.9rem;
        }

        .footer-custom {
            text-align: center;
            padding: 2rem 1rem;
            color: #7f8c8d;
            border-top: 1px solid #e9ecef;
            margin-top: 3rem;
        }

        .feature-list {
            list-style: none;
            padding: 1.5rem;
        }

        .feature-list li {
            padding: 0.75rem 0;
            color: #34495e;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .feature-list i {
            color: var(--docker-color);
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section .lead {
                font-size: 1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-docker"></i> PHP Docker
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a class="nav-link" href="1_intro/index.php">
                        <i class="bi bi-folder2"></i> Projetos
                    </a>
                    <a class="nav-link" href="phpinfo.php" target="_blank">
                        <i class="bi bi-info-circle"></i> PHP Info
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1><i class="bi bi-code-slash"></i> PHP Docker</h1>
        <p class="lead">Seu ambiente de desenvolvimento está pronto! 🚀</p>
        <div>
            <span class="status-badge <?= $class_mysql === 'success' ? 'connected' : 'disconnected' ?>">
                <i class="bi bi-database-fill"></i> MySQL: <?= $class_mysql === 'success' ? 'Conectado' : 'Desconectado' ?>
            </span>
            <span class="status-badge connected">
                <i class="bi bi-server"></i> Apache: Ativo
            </span>
            <span class="status-badge connected">
                <i class="bi bi-gear-fill"></i> PHP <?= PHP_MAJOR_VERSION ?>.<?= PHP_MINOR_VERSION ?>
            </span>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- MySQL Card -->
            <div class="col-lg-6 col-md-12">
                <div class="card mysql-card">
                    <div class="card-header-custom mysql-header">
                        <h5><i class="bi bi-database-fill"></i> Banco de Dados</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            <span class="status-badge <?= $class_mysql === 'success' ? 'connected' : 'disconnected' ?>">
                                <?= $status_mysql ?>
                            </span>
                        </p>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Host</div>
                                <div class="info-value"><code><?= $host ?></code></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Database</div>
                                <div class="info-value"><code><?= $db ?></code></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Usuário</div>
                                <div class="info-value"><code><?= $user ?></code></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Porta</div>
                                <div class="info-value"><code>3306</code></div>
                            </div>
                        </div>
                        <p class="mt-3">
                            <a href="http://localhost:8081" target="_blank" class="btn btn-mysql btn-custom">
                                <i class="bi bi-arrow-up-right"></i> Abrir phpMyAdmin
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- PHP Card -->
            <div class="col-lg-6 col-md-12">
                <div class="card php-card">
                    <div class="card-header-custom php-header">
                        <h5><i class="bi bi-code-square"></i> PHP & Servidor</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Versão PHP</div>
                                <div class="info-value"><?= PHP_VERSION ?> <span class="badge-custom badge-php">PHP <?= PHP_MAJOR_VERSION ?></span></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Sistema</div>
                                <div class="info-value"><?= PHP_OS ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Servidor</div>
                                <div class="info-value"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Fuso Horário</div>
                                <div class="info-value"><?= date_default_timezone_get() ?></div>
                            </div>
                        </div>
                        <p class="mt-3">
                            <a href="phpinfo.php" class="btn btn-php btn-custom">
                                <i class="bi bi-info-circle"></i> Detalhes do PHP
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Docker Card -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card docker-card">
                    <div class="card-header-custom docker-header">
                        <h5><i class="bi bi-docker"></i> Docker & Ambiente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3" style="color: var(--docker-color); font-weight: 600;">
                                    <i class="bi bi-box2-heart"></i> Contêineres Ativos
                                </h6>
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i> <strong>PHP</strong> - Servidor Web com PHP <?= PHP_MAJOR_VERSION ?></li>
                                    <li><i class="bi bi-check-circle-fill"></i> <strong>MySQL</strong> - Banco de dados relacional</li>
                                    <li><i class="bi bi-check-circle-fill"></i> <strong>phpMyAdmin</strong> - Gerenciador visual (porta 8081)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3" style="color: var(--docker-color); font-weight: 600;">
                                    <i class="bi bi-collection"></i> Estrutura de Arquivos
                                </h6>
                                <ul class="feature-list">
                                    <li><i class="bi bi-folder-fill"></i> <code>/www</code> - Seus arquivos PHP</li>
                                    <li><i class="bi bi-folder-fill"></i> <code>/mysql/data</code> - Dados do banco</li>
                                    <li><i class="bi bi-folder-fill"></i> <code>/config</code> - Configurações</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="alert alert-custom alert-info" role="alert">
                    <i class="bi bi-lightbulb"></i>
                    <strong> Como usar:</strong>
                    <p class="mb-0 mt-2">Coloque seus arquivos <code>.php</code> na pasta <code>/www</code> e acesse em <code>http://localhost:8080/seu-arquivo.php</code>. Acesse seus projetos em <a href="1_intro/index.php" class="link-dark fw-bold">Projetos CLI</a>.</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="row mt-4">
            <div class="col-lg-12 text-center">
                <h4 class="mb-3">Comece a explorar</h4>
                <a href="1_intro/index.php" class="btn btn-docker btn-custom me-2">
                    <i class="bi bi-folder2-open"></i> Meus Projetos
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-custom">
        <p class="mb-2">
            <i class="bi bi-docker"></i> Docker + <i class="bi bi-code-slash"></i> PHP + <i class="bi bi-database-fill"></i> MySQL
        </p>
        <p style="font-size: 0.9rem; color: #95a5a6;">
            Ambiente de desenvolvimento profissional para PHP 🚀
        </p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
