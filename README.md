# 📋 Projeto TaskManager

Sistema de Gerenciamento de Tarefas com Laravel (Backend) e Vue (Frontend)

## 📚 Tecnologias

- **Backend:** Laravel 11 + MySQL + Sanctum
- **Frontend:** Vue + Tailwind CSS + Vite
- **API:** RESTful com autenticação Bearer Token

---

## 🚀 Setup do Backend

### 1. Pré-requisitos

```bash
# Instalar dependências do sistema
sudo apt update
sudo apt install php mysql-server nodejs npm php-curl php-mbstring php-mysql php-xml php-zip
```

### 2. Instalar Composer

```bash
# Download e instalação do Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 3. Configurar MySQL

```sql
-- Entrar no MySQL
sudo mysql

-- Criar banco e usuário
CREATE DATABASE taskmanager_db;
CREATE USER 'taskmanager_user'@'localhost' IDENTIFIED BY 'senha123';
GRANT ALL PRIVILEGES ON taskmanager_db.* TO 'taskmanager_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Configurar Laravel

```bash
# Navegar para o diretório backend
cd backend/

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskmanager_db
DB_USERNAME=taskmanager_user
DB_PASSWORD=senha123

# Executar migrações e seeders
php artisan migrate --seed

# Iniciar servidor
php artisan serve
```

---

## 🌐 Setup do Frontend

### 1. Instalar dependências

```bash
# Navegar para o diretório frontend
cd frontend/

# Instalar packages
npm install
```

### 2. Configurar API URL

```javascript
// src/config/api.js
export const API_BASE_URL = 'http://localhost:8000/api';
```

### 3. Iniciar desenvolvimento

```bash
npm run dev
```

---

## 📖 Endpoints da API

### Autenticação

| Método | Endpoint | Descrição | Headers |
|--------|----------|-----------|---------|
| `POST` | `/api/register` | Registrar usuário | `Content-Type: application/json` |
| `POST` | `/api/login` | Login | `Accept: application/json` |

**Exemplo Register:**
```json
{
  "name": "João Silva",
  "email": "joao@email.com",
  "password": "senha123",
  "password_confirmation": "senha123"
}
```

### Tasks (Protegidas)

| Método | Endpoint | Descrição | Auth |
|--------|----------|-----------|------|
| `GET` | `/api/tasks` | Listar tasks | Bearer Token |
| `POST` | `/api/tasks` | Criar task | Bearer Token |
| `GET` | `/api/tasks/{id}` | Ver task | Bearer Token |
| `PUT` | `/api/tasks/{id}` | Atualizar task | Bearer Token |
| `DELETE` | `/api/tasks/{id}` | Deletar task | Bearer Token |

**Headers para requests protegidas:**
```
Authorization: Bearer {seu_token_aqui}
Content-Type: application/json
Accept: application/json
```

**Exemplo Task:**
```json
{
  "title": "Minha tarefa",
  "description": "Descrição da tarefa",
  "completed": false
}
```

---

## 🧪 Testando a API

### 1. Usuário de Teste (Seeder)
```
Email: test@example.com
Senha: password
```

### 2. Workflow de Teste

```bash
# 1. Registrar/Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# 2. Copiar o token da resposta

# 3. Listar tasks
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -H "Accept: application/json"
```

---

## 🛠️ Comandos Úteis

```bash
# Backend
php artisan migrate:fresh --seed  # Reset DB + Seeders
php artisan route:list            # Ver todas as rotas
php artisan config:clear          # Limpar cache

# Frontend
npm run build                     # Build para produção
npm run preview                   # Preview do build
```

---

## 📁 Estrutura do Projeto

```
Projeto-TaskManager/
├── backend/                 # Laravel API
│   ├── app/Http/Controllers # Controllers da API
│   ├── app/Models/          # Models (User, Task)
│   ├── database/migrations/ # Migrações do banco
│   └── routes/api.php       # Rotas da API
├── frontend/                # Vue App
│   ├── src/components/      # Componentes Vue
│   ├── src/pages/          # Páginas
│   └── src/services/       # Serviços da API
└── README.md
```

---

## 🚀 Deploy

### Backend (Laravel)
- Configure `.env` para produção
- `php artisan config:cache`
- `php artisan route:cache`

### Frontend (Vue)
- `npm run build`
- Deploy da pasta `dist/`

---

## 🤝 Contribuição

1. Fork o projeto
2. Crie sua branch (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Add: Nova feature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request