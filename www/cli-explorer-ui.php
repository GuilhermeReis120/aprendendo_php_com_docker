<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLI Projects Explorer</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Prism.js para Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css" rel="stylesheet">
    
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

        html, body {
            height: 100%;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e8ecf1 100%);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
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

        .nav-link {
            color: var(--text-secondary) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--php-color) !important;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 80px);
        }

        .sidebar {
            width: 300px;
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, rgba(119, 123, 180, 0.05) 0%, rgba(36, 150, 237, 0.05) 100%);
        }

        .sidebar-header h5 {
            margin: 0;
            color: var(--php-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .project-list {
            list-style: none;
            padding: 0.5rem;
            margin: 0;
        }

        .project-item {
            margin-bottom: 0.5rem;
            cursor: pointer;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid transparent;
            background: var(--light-bg);
            transition: all 0.3s ease;
            color: var(--text-secondary);
        }

        .project-item:hover {
            background: #e8ecf1;
            border-color: var(--docker-color);
            transform: translateX(5px);
            color: var(--text-primary);
        }

        .project-item.active {
            background: linear-gradient(135deg, rgba(119, 123, 180, 0.1) 0%, rgba(36, 150, 237, 0.1) 100%);
            border-color: var(--docker-color);
            color: var(--docker-color);
            box-shadow: 0 2px 8px rgba(36, 150, 237, 0.15);
        }

        .project-name {
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
        }

        .project-path {
            font-size: 0.75rem;
            color: #95a5a6;
            display: block;
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
            color: var(--docker-color);
        }

        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .file-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .file-card:hover {
            background: #f8f9fa;
            border-color: var(--docker-color);
            transform: translateY(-6px);
            box-shadow: 0 8px 16px rgba(36, 150, 237, 0.12);
            color: var(--docker-color);
        }

        .file-card.active {
            background: linear-gradient(135deg, rgba(119, 123, 180, 0.1) 0%, rgba(36, 150, 237, 0.1) 100%);
            border-color: var(--docker-color);
            color: var(--docker-color);
            box-shadow: 0 8px 16px rgba(36, 150, 237, 0.15);
        }

        .file-icon {
            font-size: 2.5rem;
            color: var(--docker-color);
        }

        .file-name {
            font-weight: 600;
            word-break: break-word;
            font-size: 0.9rem;
        }

        .code-viewer {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 900px;
            scroll-margin-top: 2rem;
            margin-bottom: 3rem;
        }

        .code-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(119, 123, 180, 0.05) 0%, rgba(36, 150, 237, 0.05) 100%);
            border-bottom: 1px solid var(--border-color);
            max-height: 8vh;
        }

        .code-header h5 {
            margin: 0;
            color: var(--docker-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .btn-copy {
            background: linear-gradient(135deg, var(--php-color) 0%, var(--docker-color) 100%);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-copy:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(36, 150, 237, 0.3);
            color: white;
            text-decoration: none;
        }

        pre {
            margin: 0;
            padding: 1.5rem;
            background: var(--light-bg);
            color: var(--text-primary);
            overflow: auto;
            max-height: 500px;
        }

        code {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--text-primary);
        }

        .hljs {
            background: var(--light-bg) !important;
            color: var(--text-primary) !important;
        }

        .hljs-string {
            color: #27ae60 !important;
        }

        .hljs-number {
            color: #e74c3c !important;
        }

        .hljs-literal {
            color: var(--docker-color) !important;
        }

        .hljs-attr {
            color: var(--php-color) !important;
        }

        .alert {
            border: none;
            border-radius: 12px;
            margin-bottom: 1rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            border: 1px solid rgba(39, 174, 96, 0.3);
            color: #27ae60;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #c0392b;
        }

        .badge {
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            background: linear-gradient(135deg, rgba(119, 123, 180, 0.15), rgba(36, 150, 237, 0.15));
            color: var(--docker-color);
            border: 1px solid rgba(36, 150, 237, 0.3);
        }

        .spinner-border {
            border-color: rgba(36, 150, 237, 0.2);
            border-right-color: var(--docker-color);
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                height: auto;
            }

            .sidebar {
                width: 100%;
                max-height: 40vh;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .content-area {
                padding: 1rem;
            }

            .file-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }

            .code-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        .breadcrumb-container {
            padding: 1rem 2rem;
            background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
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
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--docker-color);
            text-decoration: underline;
        }
    </style>
    </head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="bi bi-code-square"></i> CLI Explorer
            </span>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="javascript:history.back()" class="nav-link" title="Voltar">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
                <button class="btn btn-outline-info btn-sm" onclick="loadProjects()" title="Recarregar">
                    <i class="bi bi-arrow-clockwise"></i> Recarregar
                </button>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="1_intro/index.php">1_intro</a></li>
                <li class="breadcrumb-item active" id="breadcrumb-project">Projetos</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Container -->
    <div id="message-container" class="container-fluid px-4" style="padding-top: 0.5rem;"></div>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h5>
                    <i class="bi bi-folder2"></i>
                    Projetos CLI
                </h5>
            </div>
            <ul class="project-list" id="projects-list">
                <li style="padding: 2rem; text-align: center; color: #7a7d8f;">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2 mb-0">Carregando projetos...</p>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="content-area">
            <div id="main-content" class="empty-state">
                <i class="bi bi-cursor"></i>
                <h4>Selecione um projeto</h4>
                <p>Clique em um projeto na sidebar para começar</p>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Highlight.js para Syntax Highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/json.min.js"></script>

    <script>
        // Cache para armazenar dados
        const cache = {};

        // Obter parâmetro de URL
        function getUrlParameter(name) {
            const params = new URLSearchParams(window.location.search);
            return params.get(name);
        }

        // Mostrar mensagem com Bootstrap Toast
        function showMessage(text, type = 'success') {
            const container = document.getElementById('message-container');
            const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
            const icon = type === 'error' ? 'bi-exclamation-circle' : 'bi-check-circle';
            
            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show`;
            alert.role = 'alert';
            alert.innerHTML = `
                <i class="bi ${icon} me-2"></i>
                ${text}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Fechar"></button>
            `;
            
            container.innerHTML = '';
            container.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 4000);
        }

        // Carregar lista de projetos
        async function loadProjects(autoSelectProject = null) {
            try {
                const response = await fetch('cli-explorer.php?action=getProjects');
                const data = await response.json();

                if (!data.success) {
                    showMessage('Erro ao carregar projetos', 'error');
                    return;
                }

                const projectsList = document.getElementById('projects-list');
                const projects = data.projects;

                if (projects.length === 0) {
                    projectsList.innerHTML = `
                        <li style="padding: 2rem; text-align: center;">
                            <i class="bi bi-inbox" style="font-size: 2rem; color: #7a7d8f;"></i>
                            <p style="color: #7a7d8f; margin-top: 1rem;">Nenhum projeto CLI encontrado</p>
                        </li>
                    `;
                    return;
                }

                projectsList.innerHTML = projects.map((project, index) => `
                    <li class="project-item" data-project-index="${index}" data-project-path="${project.path}" onclick="selectProject(this)">
                        <span class="project-name"><i class="bi bi-gear-fill"></i> ${project.name}</span>
                        <span class="project-path">${project.path}</span>
                    </li>
                `).join('');

                showMessage(`${projects.length} projeto(s) CLI encontrado(s)! ✨`);
                
                // Auto-selecionar projeto se fornecido como parâmetro
                if (autoSelectProject) {
                    const projectElement = Array.from(document.querySelectorAll('.project-item'))
                        .find(el => el.dataset.projectPath === autoSelectProject);
                    
                    if (projectElement) {
                        selectProject(projectElement);
                    }
                }
            } catch (error) {
                showMessage('Erro ao conectar com o servidor', 'error');
                console.error(error);
            }
        }

        // Selecionar projeto
        async function selectProject(element) {
            document.querySelectorAll('.project-item').forEach(el => {
                el.classList.remove('active');
            });
            element.classList.add('active');

            const projectPath = element.dataset.projectPath;
            document.getElementById('breadcrumb-project').textContent = element.querySelector('.project-name').textContent;
            
            await loadProjectFiles(projectPath);
        }

        // Carregar arquivos do projeto
        async function loadProjectFiles(projectPath) {
            try {
                const response = await fetch(`cli-explorer.php?action=getProjectFiles&project=${encodeURIComponent(projectPath)}`);
                const data = await response.json();

                if (!data.success) {
                    document.getElementById('main-content').innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-exclamation-triangle"></i>
                            <p>${data.error}</p>
                        </div>
                    `;
                    return;
                }

                const files = data.files;
                const mainContent = document.getElementById('main-content');

                if (files.length === 0) {
                    mainContent.innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h4>Nenhum arquivo encontrado</h4>
                            <p>Este projeto não possui arquivos de código</p>
                        </div>
                    `;
                    return;
                }

                const iconsMap = {
                    'php': 'bi-filetype-php',
                    'js': 'bi-filetype-js',
                    'html': 'bi-filetype-html',
                    'css': 'bi-filetype-css',
                    'json': 'bi-filetype-json',
                    'txt': 'bi-file-text',
                    'md': 'bi-file-earmark-text',
                    'py': 'bi-filetype-py',
                    'java': 'bi-filetype-java',
                    'cpp': 'bi-filetype-cpp',
                    'c': 'bi-filetype-c'
                };

                let html = '<div class="file-grid">';
                files.forEach(file => {
                    const iconClass = iconsMap[file.ext] || 'bi-file-earmark-code';
                    html += `
                        <div class="file-card" data-file-path="${file.fullPath}" onclick="loadFileContent(this)">
                            <i class="bi ${iconClass}"></i>
                            <div class="file-name">${file.name}</div>
                            <span class="badge bg-info">${file.ext}</span>
                        </div>
                    `;
                });
                html += '</div>';

                mainContent.innerHTML = html;
            } catch (error) {
                document.getElementById('main-content').innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p>Erro ao carregar arquivos</p>
                    </div>
                `;
                console.error(error);
            }
        }

        // Carregar conteúdo do arquivo
        async function loadFileContent(element) {
            document.querySelectorAll('.file-card').forEach(el => {
                el.classList.remove('active');
            });
            element.classList.add('active');

            const filePath = element.dataset.filePath;
            console.log('Carregando arquivo:', filePath);
            
            try {
                const url = `cli-explorer.php?action=getFileContent&file=${encodeURIComponent(filePath)}`;
                const response = await fetch(url);
                const data = await response.json();

                if (!data.success) {
                    showMessage('Erro ao carregar arquivo: ' + (data.error || 'Desconhecido'), 'error');
                    return;
                }

                let highlightedContent = escapeHtml(data.content);

                const codeViewer = `
                    <div class="code-viewer mt-3">
                        <div class="code-header">
                            <h5>
                                ${data.name}
                            </h5>
                            <button class="btn-copy" onclick="copyToClipboard()">
                                Copiar
                            </button>
                        </div>
                        <pre><code id="code-content" class="language-${data.ext}">${highlightedContent}</code></pre>
                    </div>
                `;

                const mainContent = document.getElementById('main-content');
                const filesGrid = mainContent.querySelector('.file-grid');
                
                // Remover viewer anterior se existir
                const oldViewer = mainContent.querySelector('.code-viewer');
                if (oldViewer) {
                    oldViewer.remove();
                }
                
                // Criar novo viewer
                const viewerContainer = document.createElement('div');
                viewerContainer.innerHTML = codeViewer;
                mainContent.appendChild(viewerContainer.firstElementChild);
                
                // Aplicar syntax highlighting
                document.querySelectorAll('code').forEach((block) => {
                    hljs.highlightElement(block);
                });
                
                setTimeout(() => {
                    document.querySelector('.code-viewer').scrollIntoView({ behavior: 'smooth' });
                }, 100);
            } catch (error) {
                showMessage('Erro ao conectar com o servidor', 'error');
                console.error('Erro na requisição:', error);
            }
        }

        // Copiar código para clipboard
        function copyToClipboard() {
            const codeContent = document.getElementById('code-content');
            const text = codeContent.innerText;

            navigator.clipboard.writeText(text).then(() => {
                showMessage('✨ Código copiado para clipboard!');
            }).catch(() => {
                showMessage('❌ Erro ao copiar código', 'error');
            });
        }

        // Escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Inicializar ao carregar a página
        window.addEventListener('load', () => {
            const projectParam = getUrlParameter('project');
            loadProjects(projectParam);
        });
    </script>
</body>
</html>
