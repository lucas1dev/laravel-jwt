# laravel-jwt
Aplicação de api, com autenticação JWT


Configurando 
 - No arquivo config/database, editar as configurações do banco de dados
 - Realizar um migrate com, php artisan migrate

Acessos por Postman

REGISTRO
Post 
http://127.0.0.1:8000/api/register
Dados: name, username, password

LOGIN
Post http://127.0.0.1:8000/api/login
Dados: username, password

LOGOUT
Post http://127.0.0.1:8000/api/logout


