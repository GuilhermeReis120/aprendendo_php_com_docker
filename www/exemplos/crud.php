<?php
// ─────────────────────────────────────────────────────
//  Exemplo: CRUD simples com PHP + MySQL
//  Acesse: http://localhost:8080/exemplos/crud.php
// ─────────────────────────────────────────────────────

$host = 'mysql';
$db   = 'meu_banco';
$user = 'usuario';
$pass = 'senha123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Cria tabela se não existir
$pdo->exec("CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    concluida TINYINT(1) DEFAULT 0,
    criada_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// ── Ações ─────────────────────────────────────────────
$mensagem = '';

// Inserir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $titulo = trim($_POST['titulo']);
    if ($titulo !== '') {
        $stmt = $pdo->prepare("INSERT INTO tarefas (titulo) VALUES (?)");
        $stmt->execute([$titulo]);
        $mensagem = '✅ Tarefa adicionada!';
    }
}

// Concluir / Desfazer
if (isset($_GET['toggle'])) {
    $stmt = $pdo->prepare("UPDATE tarefas SET concluida = NOT concluida WHERE id = ?");
    $stmt->execute([(int)$_GET['toggle']]);
    header('Location: crud.php');
    exit;
}

// Deletar
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: crud.php');
    exit;
}

// Buscar todas
$tarefas = $pdo->query("SELECT * FROM tarefas ORDER BY criada_em DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Exemplo CRUD — Lista de Tarefas</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 600px; margin: 2rem auto; padding: 1rem; background: #f5f5f5; }
        h1 { color: #333; }
        form { display: flex; gap: 0.5rem; margin: 1rem 0; }
        input[type=text] { flex: 1; padding: 0.5rem; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem; }
        button { padding: 0.5rem 1.2rem; background: #3498db; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 1rem; }
        button:hover { background: #2980b9; }
        .tarefa { background: white; padding: 0.8rem 1rem; border-radius: 8px; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .tarefa .titulo { flex: 1; }
        .tarefa.feita .titulo { text-decoration: line-through; color: #aaa; }
        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.8rem; text-decoration: none; border-radius: 5px; }
        .btn-toggle { background: #2ecc71; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .msg { background: #d4edda; color: #155724; padding: 0.6rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .vazio { color: #aaa; text-align: center; padding: 2rem; }
    </style>
</head>
<body>

<h1>📝 Lista de Tarefas</h1>
<p><a href="/index.php">← Voltar para o início</a></p>

<?php if ($mensagem): ?>
    <div class="msg"><?= htmlspecialchars($mensagem) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="titulo" placeholder="Nova tarefa..." required autofocus>
    <button type="submit">Adicionar</button>
</form>

<?php if (empty($tarefas)): ?>
    <p class="vazio">Nenhuma tarefa ainda. Adicione uma acima! 👆</p>
<?php else: ?>
    <?php foreach ($tarefas as $t): ?>
        <div class="tarefa <?= $t['concluida'] ? 'feita' : '' ?>">
            <span class="titulo"><?= htmlspecialchars($t['titulo']) ?></span>
            <a class="btn-sm btn-toggle" href="?toggle=<?= $t['id'] ?>">
                <?= $t['concluida'] ? '↩ Desfazer' : '✔ Concluir' ?>
            </a>
            <a class="btn-sm btn-delete" href="?delete=<?= $t['id'] ?>"
               onclick="return confirm('Tem certeza?')">🗑 Apagar</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- ── Código explicado abaixo ─────────────────────────────── -->
<details style="margin-top:2rem; background:white; padding:1rem; border-radius:8px;">
    <summary style="cursor:pointer; font-weight:bold">📚 Ver o código explicado</summary>
    <pre style="margin-top:1rem; font-size:0.85rem; overflow-x:auto; line-height:1.6">
// 1. Conectar ao banco (PDO)
$pdo = new PDO("mysql:host=mysql;dbname=meu_banco", "usuario", "senha123");

// 2. INSERT – Inserir um registro
$stmt = $pdo->prepare("INSERT INTO tarefas (titulo) VALUES (?)");
$stmt->execute(["Minha tarefa"]);

// 3. SELECT – Buscar todos os registros
$tarefas = $pdo->query("SELECT * FROM tarefas")->fetchAll();

// 4. UPDATE – Atualizar um registro
$stmt = $pdo->prepare("UPDATE tarefas SET concluida = 1 WHERE id = ?");
$stmt->execute([1]);

// 5. DELETE – Apagar um registro
$stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
$stmt->execute([1]);
    </pre>
</details>

</body>
</html>
