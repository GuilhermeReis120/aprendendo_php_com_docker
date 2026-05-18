# 🐳 PHP Dev Stack com Docker

> Ambiente de desenvolvimento PHP completo — o seu **XAMPP moderno** usando Docker.  
> Inclui **PHP 8.2 + Apache**, **MySQL 8** e **phpMyAdmin**, tudo com um único comando.

---

## 📋 O que está incluído

| Serviço      | Versão   | Porta local          |
|--------------|----------|----------------------|
| PHP + Apache | 8.2      | http://localhost:8080 |
| MySQL        | 8.0      | localhost:3306        |
| phpMyAdmin   | latest   | http://localhost:8081 |

---

## ✅ Pré-requisitos

Antes de começar, você precisa ter instalado:

- **Docker Desktop** → https://www.docker.com/products/docker-desktop
- **Git** (opcional, mas recomendado) → https://git-scm.com

> 💡 **Dica:** O Docker Desktop já inclui o `docker compose`. Basta instalar ele e está pronto!

---

## 🚀 Como iniciar o ambiente

### 1. Baixe e extraia o projeto

Extraia o `.zip` que você baixou em uma pasta de sua preferência.  
Exemplo: `C:\projetos\php-docker` (Windows) ou `~/projetos/php-docker` (Mac/Linux)

---

### 2. Abra o terminal na pasta do projeto

**Windows:**  
Clique com o botão direito dentro da pasta → *"Abrir no Terminal"*  
(ou use o PowerShell / Prompt de Comando e navegue com `cd C:\projetos\php-docker`)

**Mac / Linux:**  
```bash
cd ~/projetos/php-docker
```

---

### 3. Suba os containers

```bash
docker compose up -d
```

> Na **primeira vez**, o Docker vai baixar as imagens e construir o ambiente.  
> Isso pode levar alguns minutos dependendo da sua internet. ☕  
> Nas próximas vezes, sobe em segundos!

---

### 4. Acesse no navegador

| O que acessar | URL |
|---|---|
| 🏠 Sua aplicação PHP | http://localhost:8080 |
| 📊 phpMyAdmin | http://localhost:8081 |

---

## 🗂️ Estrutura do Projeto

```
php-docker/
│
├── 📄 docker-compose.yml       ← Orquestra todos os serviços
├── 📄 Dockerfile               ← Configuração da imagem PHP+Apache
├── 📄 .gitignore
│
├── 📁 www/                     ← ⭐ SEUS ARQUIVOS PHP FICAM AQUI!
│   ├── index.php               ← Página inicial (painel de status)
│   ├── phpinfo.php             ← Informações completas do PHP
│   └── exemplos/
│       └── crud.php            ← Exemplo de CRUD completo
│
├── 📁 config/
│   └── php/
│       └── php.ini             ← Configurações do PHP (erros, memória, etc.)
│
└── 📁 mysql/
    └── data/                   ← Dados do banco (gerado automaticamente)
```

> **A pasta `www/` é a pasta raiz do servidor**, equivalente ao `htdocs` do XAMPP.  
> Tudo que você colocar lá fica disponível em `http://localhost:8080/`.

---

## 🗄️ Banco de Dados

### Credenciais

| Campo | Valor |
|-------|-------|
| Host (dentro do Docker) | `mysql` |
| Host (fora do Docker / Workbench) | `localhost` |
| Porta | `3306` |
| Banco padrão | `meu_banco` |
| Usuário | `usuario` |
| Senha | `senha123` |
| Usuário root | `root` |
| Senha root | `root` |

### Conectar via PHP (PDO) — recomendado

```php
<?php
$pdo = new PDO(
    "mysql:host=mysql;dbname=meu_banco;charset=utf8mb4",
    "usuario",
    "senha123",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
```

### Conectar via PHP (MySQLi) — alternativa

```php
<?php
$conn = new mysqli("mysql", "usuario", "senha123", "meu_banco");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
```

> ⚠️ **Importante:** Dentro do PHP (que roda no Docker), use `mysql` como host.  
> Fora do Docker (MySQL Workbench, DBeaver), use `localhost`.

---

## 📊 Acessando o phpMyAdmin

1. Abra **http://localhost:8081** no navegador
2. Faça login com:
   - **Usuário:** `root`
   - **Senha:** `root`

No phpMyAdmin você pode:
- Criar e gerenciar bancos de dados
- Criar tabelas e inserir dados
- Executar queries SQL
- Exportar/importar dados

---

## 🔧 Comandos Úteis

### Iniciar o ambiente
```bash
docker compose up -d
```

### Parar o ambiente (mantém os dados)
```bash
docker compose stop
```

### Parar e remover os containers
```bash
docker compose down
```

### Ver os logs em tempo real
```bash
docker compose logs -f
```

### Ver logs só do PHP
```bash
docker compose logs -f php
```

### Entrar no container PHP (terminal)
```bash
docker exec -it php_apache bash
```

### Entrar no MySQL via terminal
```bash
docker exec -it mysql_db mysql -uroot -proot
```

### Reconstruir a imagem PHP (após editar o Dockerfile)
```bash
docker compose up -d --build
```

---

## 🧰 Extensões PHP incluídas

| Extensão | Para que serve |
|----------|---------------|
| `pdo` + `pdo_mysql` | Conexão moderna com banco de dados |
| `mysqli` | Conexão alternativa com MySQL |
| `gd` | Manipulação de imagens |
| `zip` | Trabalhar com arquivos ZIP |
| `mbstring` | Strings com acentos/Unicode |
| `xml` | Parsing de XML |
| `opcache` | Cache de scripts PHP (mais performance) |
| `composer` | Gerenciador de pacotes PHP |

---

## 📦 Usando o Composer

O **Composer** já está instalado no container. Para instalar pacotes:

```bash
# Entrar no container
docker exec -it php_apache bash

# Instalar um pacote (exemplo: Carbon para datas)
composer require nesbot/carbon

# Voltar ao seu sistema
exit
```

---

## ⚙️ Personalizando as configurações

### Alterar configurações do PHP

Edite o arquivo `config/php/php.ini`.  
Depois, reinicie o container para aplicar:

```bash
docker compose restart php
```

### Alterar usuário/senha do banco

Edite as variáveis em `docker-compose.yml` na seção `mysql > environment`.  
Depois, recrie os containers:

```bash
docker compose down
docker compose up -d
```

> ⚠️ Se o banco já tinha dados, apague a pasta `mysql/data/` antes de recriar.

---

## 🎓 Exemplos incluídos

### 📝 CRUD de Tarefas
Acesse: **http://localhost:8080/exemplos/crud.php**

Um exemplo completo de **Create, Read, Update, Delete** com:
- Formulário para adicionar tarefas
- Listagem com status (concluída / pendente)
- Botões de toggle e exclusão
- Código comentado e explicado

---

## ❓ Perguntas Frequentes

**Q: A porta 8080 ou 3306 já está em uso, o que fazer?**  
A: Edite o `docker-compose.yml` e mude as portas. Ex: `"9090:80"` para usar a porta 9090.

**Q: Posso usar MySQL Workbench ou DBeaver?**  
A: Sim! Conecte em `localhost:3306` com usuário `root` e senha `root`.

**Q: Os dados do banco são perdidos quando eu paro o Docker?**  
A: Não! Os dados ficam salvos na pasta `mysql/data/` e persistem entre reinicializações.

**Q: Como faço para usar um banco de dados diferente?**  
A: No phpMyAdmin, crie um novo banco. Ou crie diretamente no PHP com `CREATE DATABASE nome;`.

**Q: Como instalo extensões PHP adicionais?**  
A: Edite o `Dockerfile`, adicione a extensão na lista do `docker-php-ext-install`, e execute `docker compose up -d --build`.

---

## 🆚 Comparativo: Docker vs XAMPP

| | Docker (este projeto) | XAMPP |
|---|---|---|
| Isolamento | ✅ Separado do sistema | ❌ Instala no sistema |
| Versão do PHP | ✅ Fácil de trocar | ⚠️ Complicado |
| Múltiplos projetos | ✅ Um ambiente por projeto | ❌ Todos compartilham |
| Limpeza | ✅ `docker compose down` | ❌ Desinstalar manualmente |
| Colaboração | ✅ Mesmo ambiente para todos | ❌ Depende do SO |

---

## 📄 Licença

Projeto de código aberto para fins educacionais. Fique à vontade para modificar e aprender!

---

Feito com ❤️ para aprender PHP do jeito moderno 🚀
