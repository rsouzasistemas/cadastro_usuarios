<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Cadastro de Usuários

Projeto de teste prático para vaga de programador Laravel.

O teste consiste em aplicação web utilizando Laravel, jQuery, HTML e CSS que permita cadastrar usuários, exibir a lista de usuários cadastrados em uma tabela e excluir usuários.

Requisitos:

- O aplicativo deve ter uma página inicial com um formulário de cadastro de usuário.
- O formulário de cadastro de usuário deve ter os seguintes campos: nome, e-mail e telefone.
- Ao preencher o formulário e clicar no botão "Cadastrar", o usuário deve ser adicionado à lista de usuários cadastrados e a tabela de usuários deve ser atualizada.
- A tabela de usuários deve exibir as seguintes colunas: ID, nome, e-mail, telefone e uma coluna de ação para excluir o usuário.
- Ao clicar no botão de exclusão na tabela, o usuário correspondente deve ser removido da lista de usuários cadastrados e a tabela deve ser atualizada.
- O aplicativo deve ter um layout básico utilizando HTML e CSS.

Adicional:

- Você pode criar uma estrutura de login para cada usuário cadastrado.
- Você pode criar uma estrutura para poder cadastrar mais de um telefone para o usuário.


## Instalação do Projeto

O projeto foi desenvolvido usando Laravel 10, por isso, existem alguns requisitos para conseguir rodá-lo. Você precisa ter instalado:

- Apache ou Nginx (Opcional)
- PHP >= 8.1
- Composer
- NPM
- MySQL/MariaDB/PostgreSQL (apenas um deles)

Com tudo instalado e configurado, siga os passos abaixo:

- Clone o projeto para o local configurado para rodar seus aplicativos web
- Faça uma cópia do arquivo .env.example e renomeie-o para .env
    - Observação: Por padrão, o ambiente configurado é o de desenvolvimento!
- Abra o CLI de sua preferência e acesse a pasta do projeto
- Digite o comando: composer install
- Digite o comando: php artisan key:generate
- Configure as variável de ambiente dentro do arquivo .env, indicando o banco de dados em que o projeto se conectará
- Digite o comando: npm install && npm run dev (para hot reload) ou, npm install && npm run build (para static load)
    - Observação: O npm install só precisa ser executado na primeira instalação do projeto.
- Digite o comando: php artisan migrate --seed
- Acesse o endereço indicado anteriormente no CLI, provavelmente será [localhost](http://localhost)
- Caso não esteja usando um servidor web, use o comando: "php artisan serve" para iniciar o servidor do próprio PHP. O endereço de acesso será exibido ao final do carregamento.

Para logar no app, use as credenciais abaixo (certifique-se de ter executado os comandos da lista acima!):

- Usuário: teste@example.com
- Senha: 12345678
