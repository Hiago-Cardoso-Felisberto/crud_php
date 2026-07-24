# Projeto Laravel com Docker e Postgres

## 1. Clonar o repositório
git clone https://seu-repositorio.git
cd nome-do-projeto

## 2. Pré-requisitos
- Docker Desktop: https://docs.docker.com/get-docker/
- Docker Compose: já vem junto com o Docker Desktop nas versões atuais.
- PHP/Composer (opcional, se quiser rodar fora do container)
- Node/NPM (se houver frontend com React/Vue)

## 3. Configurar variáveis de ambiente
Copie o arquivo `.env.example` para `.env`:
cp .env.example .env

Edite o `.env` conforme necessário (nome do banco, usuário e senha).

Depois, gere a chave da aplicação:
docker exec -it laravel_app php artisan key:generate

Cole em APP_KEY= 

## 4. Subir o ambiente
docker-compose up --build -d

## 5. Banco de Dados
Seed para popular banco: feita a partir do DatabaseSeeder.php, que carrega dados iniciais para as tabelas.

### 5.1 Apenas migrations
docker exec -it laravel_app php artisan migrate

### 5.2 Apenas seeders
docker exec -it laravel_app php artisan db:seed

### 5.3 Migrations e seeders juntos
docker exec -it laravel_app php artisan migrate --seed

### 5.4 Resetar banco (migrations + seeders do zero)
docker exec -it laravel_app php artisan migrate:fresh --seed

## 6. Acessar aplicação
Abra no navegador:
http://localhost:8000

## 7. Acessar documentação da API (Swagger)
Abra no navegador:
http://localhost:8000/api/documentation

> Observação: o comando `php artisan l5-swagger:generate` só é necessário se você alterar ou adicionar anotações nos controllers. Caso contrário, a documentação já estará disponível.

## 8. Comandos úteis
### Limpar caches
docker exec -it laravel_app php artisan config:clear
docker exec -it laravel_app php artisan cache:clear
docker exec -it laravel_app php artisan route:clear
docker exec -it laravel_app php artisan view:clear

## 9. Estrutura do Projeto

### app\Http\Controllers
- Gerenciados por: routes\web.php
- Fluxo: Controller -> Service -> Repository
- Cada controller cuida da requisição de uma tela específica.
- Services cuidam das regras e validações de dados.
- Repositories cuidam das conexões com o banco (busca, criação, alteração e exclusão).

### app\Http\Controllers\Api
- Gerenciados por: routes\api.php
- Cada controller responde às requisições feitas pelo Swagger.
- Services e Repositories são os mesmos usados pelos controllers web.

### app\Swagger
- Responsável por carregar as informações de versão que o Swagger usa para rodar.

### app\Models
- Contém as entidades: Consulta, Especialidade, Medico, Paciente, TipoConsulta, User.

## 10. Modelagem do Banco (Models)

### Consulta
- Campos: paciente_id, medico_id, tipo_consulta_id, data_atendimento, valor_consulta
- Relações:
  - belongsTo Paciente
  - belongsTo Medico
  - belongsTo TipoConsulta

### Especialidade
- Campos: nome
- Relações:
  - belongsToMany Medico (tabela medico_especialidade)
  - belongsToMany TipoConsulta (tabela tipo_consulta_especialidade)

### Medico
- Campos: nome, crm
- Relações:
  - belongsToMany Especialidade (tabela medico_especialidade)
  - hasMany Consulta

### Paciente
- Campos: nome, cpf, data_nascimento, telefone
- Relações:
  - hasMany Consulta

### TipoConsulta
- Campos: nome, duracao, hora_inicio, hora_fim
- Relações:
  - belongsToMany Especialidade (tabela tipo_consulta_especialidade)
  - hasMany Consulta

### app\Repositories
- Contém os repositórios responsáveis pelo acesso ao banco.

### database
- migrations: geradas com `artisan make:migration`, respeitando os modelos.
- seeders: `DatabaseSeeder` chama as demais classes em ordem para popular as tabelas e respeitar as relações.

### resources\views
- home: tela inicial com links para as demais telas.
- Cada tela tem suas pastas com index, create e edit.
- master: carrega header e footer, reaproveitado em todas as views.

### routes
- api.php: cuida das controllers API, consumidas pelo Swagger.
- web.php: cuida das rotas consumidas pelas controllers usando Blade.

## 11. Git Flow
Fluxo esperado:
- Fork do repositório
- Clone
- Commits durante o desenvolvimento
- Pull Request para entrega


## 12. Diferenciais implementados
- Paginação: feita com jQuery
- Busca por paciente/médico: feita com jQuery
- Ordenação da listagem: feita com jQuery
- Validação de formulários: feita no service de cada controller
- Tratamento de erros: try/catch
- Logs: session com success e error 
- Seed para popular banco: feita a partir do DatabaseSeeder.php
- Migrações: feitas em ordem para respeitar as relações
- Uso de ORM: implementado com Eloquent, utilizando relacionamentos (belongsTo, hasMany, belongsToMany) para mapear as entidades
- Boas práticas de Clean Code: separação de responsabilidades em camadas, nomes claros para classes/métodos, reaproveitamento de código nas views, uso de migrations/seeders e tratamento de exceções
- Documentação da API (Swagger/OpenAPI): utilizando "darkaonline/l5-swagger": "^8.0", versão mais nova estava dando erro em "@OA\Info"


## 13. Tecnologias
- Backend: PHP (Laravel)
- Frontend: Blade (HTML, CSS, JS)
- Banco: PostgreSQL
- Docker: Dockerfile + docker-compose.yml
