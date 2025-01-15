# BiblioTech - Sistema de Biblioteca Online

## Propósito do Projeto

O **BiblioTech - Sistema de Biblioteca Online** é uma aplicação web projetada para facilitar o gerenciamento e o acesso ao acervo de uma biblioteca. Ele permite que os usuários procurem livros, façam solicitações de empréstimos e acompanhem devoluções, enquanto administradores (bibliotecários) têm acesso a ferramentas de controle para gerenciar o acervo e os registros. A solução busca digitalizar os processos da biblioteca, tornando-os mais rápidos, organizados e acessíveis.

## Objetivos

### Objetivo Principal

Desenvolver uma plataforma digital eficiente e acessível para o gerenciamento de bibliotecas e o acesso a livros pelos usuários.

### Objetivo Secundário

Facilitar a busca por livros através de filtros intuitivos (título, autor e gênero) e visualização e gerenciamento dos empréstimos.

## Como Configurar e Executar a Aplicação

1. **Instalar o XAMPP**: O XAMPP é necessário para configurar um servidor Apache e um banco de dados MySQL para rodar a aplicação. ([https://www.apachefriends.org/pt_br/index.html](https://www.apachefriends.org/pt_br/index.html))
   
2. **Iniciar o XAMPP**: Após a instalação, inicie os módulos **Apache** e **MySQL** no painel de controle do XAMPP.
   
3. **Inserir o Script de Tabelas**: Acesse o banco de dados no MySQL e insira o script presente em `tabelas.txt` para popular as tabelas necessárias.

4. **Acessar a Aplicação**: Com o XAMPP em funcionamento, acesse a aplicação através do navegador com o endereço [http://localhost/projeto-back-front](http://localhost/projeto-back-front).

## Estrutura e Principais Funcionalidades

### Acesso aos Livros
- **Home do Usuário Comum**: Após realizar login ou registro, o usuário comum é direcionado à página inicial, que lista todos os livros disponíveis na biblioteca. 
  - **Sessão de Busca**: O usuário pode procurar livros através de filtros como título, autor e gênero.
  - **Meus Empréstimos**: O usuário pode acessar seu histórico de empréstimos, visualizando a data de empréstimo, data de devolução e o status do livro (reservado, devolvido ou pendente).

### Área Administrativa (Bibliotecário)
- **Home do Administrador**: O bibliotecário tem acesso a uma área principal com três abas para gerenciar os livros e os empréstimos:
  1. **Cadastrar Livro**: Permite ao bibliotecário adicionar novos livros ao acervo.
  2. **Listar Livros**: Exibe a lista completa de livros no acervo.
  3. **Visualizar Empréstimos**: Exibe uma lista de todos os empréstimos realizados, incluindo nome do usuário, livro, datas e status do empréstimo (pendente, devolvido ou reservado). O bibliotecário também pode atualizar o status dos empréstimos nesta área.

### Funcionalidades Comuns
- **Edição de Perfil**: Tanto o usuário comum quanto o administrador possuem uma área para editar seus dados pessoais, como nome, e-mail e senha.
- **Área de Contato**: Ambos os usuários podem enviar mensagens para o suporte da Biblioteca para questões ou dúvidas diretamente através de um formulário de contato.

## Tecnologias Utilizadas

- **HTML5**
- **CSS3**
- **JavaScript**
- **PHP**
- **MySQL**

