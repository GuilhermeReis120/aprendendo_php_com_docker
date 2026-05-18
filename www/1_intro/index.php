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
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Meus Projetos - 1_intro</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #eee;
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #a8dadc, #457b9d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .header p {
            color: #aaa;
            font-size: 1.1rem;
        }
        
        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            color: #888;
        }
        
        .breadcrumb a {
            color: #0f3460;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb a:hover {
            color: #a8dadc;
        }
        
        .projetos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .projeto-card {
            background: rgba(22, 33, 62, 0.8);
            border: 2px solid rgba(47, 51, 78, 0.5);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }
        
        .projeto-card:hover {
            background: rgba(22, 33, 62, 1);
            border-color: #533483;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(83, 52, 131, 0.2);
        }
        
        .projeto-icon {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }
        
        .projeto-nome {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: capitalize;
        }
        
        .projeto-desc {
            font-size: 0.9rem;
            color: #aaa;
            flex-grow: 1;
            margin-bottom: 1rem;
        }
        
        .projeto-link {
            display: inline-block;
            background: linear-gradient(135deg, #0f3460, #533483);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            align-self: flex-start;
        }
        
        .projeto-link:hover {
            background: linear-gradient(135deg, #533483, #0f3460);
            transform: scale(1.05);
        }
        
        .vazio {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(22, 33, 62, 0.5);
            border-radius: 12px;
            border: 2px dashed rgba(47, 51, 78, 0.5);
        }
        
        .vazio h2 {
            color: #aaa;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }
        
        .vazio p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .vazio code {
            background: #0a0a1a;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            color: #a8dadc;
            display: block;
            margin: 1rem 0;
            font-size: 0.9rem;
            overflow-x: auto;
        }
        
        .footer {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(47, 51, 78, 0.3);
        }
        
        .instrucoes {
            background: rgba(83, 52, 131, 0.1);
            border-left: 4px solid #533483;
            padding: 1.2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            color: #ddd;
        }
        
        .instrucoes strong {
            color: #a8dadc;
        }
        
        @media (max-width: 768px) {
            .header h1 { font-size: 1.8rem; }
            .projetos-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📚 Meus Projetos</h1>
        <p>Navegue entre seus projetos da seção 1_intro</p>
    </div>
    
    <div class="breadcrumb">
        <a href="../">← Voltar para www</a>
        <span>/</span>
        <span>1_intro</span>
    </div>
    
    <?php if (empty($projetos)): ?>
        <div class="instrucoes">
            <strong>💡 Como adicionar projetos:</strong>
            <p>Crie pastas com seus projetos dentro de <code>www/1_intro/</code>. Cada pasta será exibida aqui como um projeto.</p>
            <p style="margin-top: 0.8rem;">Exemplo: <code>www/1_intro/meu-projeto/index.php</code></p>
        </div>
        
        <div class="vazio">
            <h2>🚀 Nenhum projeto encontrado</h2>
            <p>Crie uma pasta aqui com seu projeto para começar!</p>
            <code>www/1_intro/seu-projeto/</code>
        </div>
    <?php else: ?>
        <div class="projetos-grid">
            <?php foreach ($projetos as $projeto): 
                $descricao = $descricoes[$projeto] ?? 'Projeto PHP';
                $icone = match($projeto) {
                    'crud' => '📝',
                    'blog' => '📰',
                    'api' => '🔌',
                    'formulario' => '📋',
                    default => '📁'
                };
            ?>
                <a href="<?= htmlspecialchars($projeto) ?>/" class="projeto-card">
                    <div class="projeto-icon"><?= $icone ?></div>
                    <div class="projeto-nome"><?= htmlspecialchars($projeto) ?></div>
                    <div class="projeto-desc"><?= htmlspecialchars($descricao) ?></div>
                    <div class="projeto-link">Abrir →</div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="footer">
        <p>💻 Ambiente PHP Docker | 🐳 Desenvolvido para estudos</p>
    </div>
</div>
</body>
</html>
