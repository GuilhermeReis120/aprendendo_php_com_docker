<?php
/**
 * CLI Projects Explorer
 * Detecta automaticamente projetos com "cli" no nome e exibe uma interface web
 */

header('Content-Type: application/json; charset=utf-8');

// Função para encontrar todos os projetos com "cli" no nome
function findCliProjects($dir, &$projects = []) {
    if (!is_dir($dir)) {
        return $projects;
    }

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        
        // Se o nome contém "cli", adicionar à lista
        if (stripos($item, 'cli') !== false && is_dir($path)) {
            $projects[] = [
                'name' => $item,
                'path' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $path),
                'fullPath' => $path
            ];
        }
        
        // Continuar procurando em subdiretórios
        if (is_dir($path) && stripos($item, 'cli') === false) {
            findCliProjects($path, $projects);
        }
    }
    
    return $projects;
}

// Função para obter lista de arquivos recursivamente
function getFilesInProject($dir) {
    $files = [];
    if (!is_dir($dir)) return $files;
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace($dir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
            
            // Incluir apenas arquivos de texto/código
            if (in_array($ext, ['php', 'js', 'html', 'css', 'json', 'txt', 'md', 'py', 'java', 'cpp', 'c'])) {
                // Caminho relativo ao DOCUMENT_ROOT
                $pathRelativeToRoot = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file->getPathname());
                
                $files[] = [
                    'name' => $file->getFilename(),
                    'relativePath' => $relativePath,
                    'fullPath' => $pathRelativeToRoot,
                    'ext' => $ext
                ];
            }
        }
    }
    
    return $files;
}

// Tratar requisições AJAX
$action = $_GET['action'] ?? null;

if ($action === 'getProjects') {
    $baseDir = $_SERVER['DOCUMENT_ROOT'];
    $projects = findCliProjects($baseDir);
    echo json_encode(['success' => true, 'projects' => $projects]);
    exit;
}

if ($action === 'getProjectFiles') {
    $projectPath = $_GET['project'] ?? '';
    $projectPath = str_replace('..', '', $projectPath); // Segurança
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $projectPath;
    
    if (!is_dir($fullPath)) {
        echo json_encode(['success' => false, 'error' => 'Projeto não encontrado']);
        exit;
    }
    
    $files = getFilesInProject($fullPath);
    echo json_encode(['success' => true, 'files' => $files]);
    exit;
}

if ($action === 'getFileContent') {
    $filePath = $_GET['file'] ?? '';
    $filePath = str_replace('..', '', $filePath); // Segurança
    
    // Se o caminho não começa com /, adicionar
    if (strpos($filePath, '/') !== 0) {
        $filePath = '/' . $filePath;
    }
    
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $filePath;
    
    if (!file_exists($fullPath) || !is_file($fullPath)) {
        echo json_encode(['success' => false, 'error' => 'Arquivo não encontrado: ' . $fullPath]);
        exit;
    }
    
    $content = file_get_contents($fullPath);
    $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
    
    echo json_encode([
        'success' => true,
        'name' => basename($fullPath),
        'content' => $content,
        'ext' => $ext
    ]);
    exit;
}

// Se não houver ação, retornar erro
echo json_encode(['success' => false, 'error' => 'Ação inválida']);
exit;
?>
