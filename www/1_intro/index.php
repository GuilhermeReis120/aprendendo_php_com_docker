<?php
// ─────────────────────────────────────────────────────
//  Índice de Projetos - 1_intro
//  Interface para acessar projetos via URL
// ─────────────────────────────────────────────────────

// Escaneiar diretório para encontrar projetos
$dirAtual = __DIR__;
$todosOsItens = scandir($dirAtual);

// Filtrar apenas diretórios (projetos) e excluir . e ..
$projetos = array_filter($todosOsItens, function($item) use ($dirAtual) {
    return $item !== '.' && 
           $item !== '..' && 
           $item !== 'index.php' && 
           is_dir($dirAtual . '/' . $item);
});

// Ordenar alfabeticamente
sort($projetos);

// Dados de cada projeto (pode ser expandido com descrições)
$descricoes = [
    'crud' => 'Sistema CRUD simples com PHP e MySQL',
    'blog' => 'Blog básico com categorias',
    'api' => 'API RESTful em PHP',
    'formulario' => 'Exemplos de formulários',
    'calculadora_cli' => 'Calculadora CLI com interface web',
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Meus Projetos - 1_intro</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --php-color: #777bb4;
            --docker-color: #2496ed;
            --light-bg: #f5f7fa;
            --card-bg: #ffffff;
            --border-color: #e9ecef;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
        }

        html, body {
            height: 100%;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e8ecf1 100%);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section {
            text-align: center;
            padding: 3rem 1rem 2rem;
        }

        .header-section h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .header-section p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .breadcrumb-container {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .breadcrumb {
            margin: 0;
        }

        .breadcrumb-item {
            color: var(--text-secondary);
        }

        .breadcrumb-item.active {
            color: var(--docker-color);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--php-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--docker-color);
            text-decoration: underline;
        }

        .projetos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .projeto-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .projeto-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(36, 150, 237, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .projeto-card:hover::before {
            left: 100%;
        }

        .projeto-card:hover {
            background: #f8f9fa;
            border-color: var(--docker-color);
            transform: translateY(-8px);
            box-shadow: 0 10px 24px rgba(36, 150, 237, 0.15);
        }

        .projeto-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--docker-color);
        }

        .projeto-nome {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: capitalize;
            color: var(--text-primary);
        }

        .projeto-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            flex-grow: 1;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .projeto-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            color: #fff;
            padding: 0.7rem 1.3rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            align-self: flex-start;
            width: fit-content;
            position: relative;
            z-index: 1;
        }

        .projeto-link:hover {
            background: linear-gradient(135deg, var(--docker-color) 0%, var(--php-color) 100%);
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(36, 150, 237, 0.3);
            color: #fff;
            text-decoration: none;
        }

        .alert-info {
            background: rgba(13, 206, 240, 0.1);
            border: 1px solid rgba(13, 206, 240, 0.3);
            border-radius: 12px;
            color: #0dcaf0;
            margin-bottom: 2rem;
        }

        .alert-info strong {
            color: #0099cc;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e8ecf1 100%);
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            margin: 2rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--docker-color);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .empty-state code {
            background: #ecf0f1;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            color: var(--php-color);
            display: block;
            margin: 1rem 0;
            font-size: 0.9rem;
            width: 750px;
        }

        .footer {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-top: 3rem;
            padding: 2rem 1rem;
            border-top: 1px solid var(--border-color);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #0dcaf0;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-back:hover {
            color: #0099cc;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .header-section h1 { font-size: 1.8rem; }
            .projetos-grid { grid-template-columns: 1fr; }
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: var(--docker-color) var(--border-color);
        }

        *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        *::-webkit-scrollbar-track {
            background: var(--border-color);
        }

        *::-webkit-scrollbar-thumb {
            background: var(--docker-color);
            border-radius: 4px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: var(--php-color);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="bi bi-collection"></i> PHP Projects
            </span>
            <a href="../" class="btn btn-outline-info btn-sm">
                <i class="bi bi-arrow-left"></i> Voltar para www
            </a>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">1_intro</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <div class="header-section">
        <h1><i class="bi bi-folder2-open"></i> Meus Projetos</h1>
        <p>Navegue entre seus projetos da seção 1_intro</p>
    </div>

    <!-- Main Content -->
    <div class="container">
        <?php if (empty($projetos)): ?>
            <div class="alert alert-info">
                <i class="bi bi-lightbulb"></i>
                <strong> Como adicionar projetos:</strong>
                <p class="mb-0 mt-2">Crie pastas com seus projetos dentro de <code>www/1_intro/</code>. Cada pasta será exibida aqui como um projeto.</p>
                <p class="mb-0 mt-2">Exemplo: <code>www/1_intro/meu-projeto/index.php</code></p>
            </div>
            
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3>🚀 Nenhum projeto encontrado</h3>
                <p>Crie uma pasta aqui com seu projeto para começar!</p>
                <code>www/1_intro/seu-projeto/</code>
            </div>
        <?php else: ?>
            <div class="projetos-grid">
                <?php foreach ($projetos as $projeto): 
                    $descricao = $descricoes[$projeto] ?? 'Projeto PHP';
                    $ehCli = stripos($projeto, 'cli') !== false;
                    
                    $icones = [
                        'crud' => 'bi-table',
                        'blog' => 'bi-newspaper',
                        'api' => 'bi-plug',
                        'formulario' => 'bi-clipboard-check',
                        'calculadora_cli' => 'bi-calculator',
                    ];
                    
                    $iconClass = 'bi-folder';
                    foreach ($icones as $chave => $classe) {
                        if (stripos($projeto, $chave) !== false) {
                            $iconClass = $classe;
                            break;
                        }
                    }
                    
                    // Se é um projeto CLI, redirecionar para o CLI Explorer
                    $href = $ehCli 
                        ? '../../cli-explorer-ui.php?project=' . urlencode('/1_intro/' . $projeto)
                        : htmlspecialchars($projeto) . '/';
                ?>
                    <a href="<?= $href ?>" class="projeto-card">
                        <i class="bi <?= $iconClass ?>"></i>
                        <div class="projeto-nome"><?= htmlspecialchars($projeto) ?></div>
                        <div class="projeto-desc"><?= htmlspecialchars($descricao) ?></div>
                        <div class="projeto-link">
                            <span><?= $ehCli ? 'Explorar' : 'Abrir' ?></span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>
            <i class="bi bi-code-square"></i> Ambiente PHP Docker | 
            <i class="bi bi-docker"></i> Desenvolvido para estudos
        </p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
