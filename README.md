# E-commerce em PHP

Este é um projeto simples de loja online desenvolvido em PHP com MySQL, com funcionalidades básicas de cadastro de produtos, carrinho de compras e controle de estoque. O projeto utiliza Docker para facilitar o ambiente de desenvolvimento.

---

## Funcionalidades

- Cadastro de produtos com nome, descrição, preço, quantidade em estoque e imagem
- Listagem responsiva de produtos
- Página de detalhes do produto
- Carrinho de compras com atualização automática da quantidade
- Controle dinâmico do estoque (estoque diminui ao adicionar ao carrinho)
- Bloqueio do botão "Adicionar ao carrinho" quando o estoque está zerado
- Finalização do pedido e limpeza do carrinho
- Upload de imagens dos produtos

---

## Tecnologias

- PHP 7/8
- MySQL 8
- Apache
- Docker / Docker Compose
- HTML5, CSS3

---

## Como rodar o projeto

1. Clone o repositório:

   ```bash
   git clone <url-do-repositorio>
   cd nome-do-projeto
   ```

2. Certifique-se de ter o Docker e Docker Compose instalados.

3. Configure o arquivo docker-compose.yml para mapear o volume do banco e o script de inicialização (db/init.sql) para criar o banco e inserir produtos.

4. Rode os containers:
   ```
   docker-compose up --build
   ```
   
5. Acesse no navegador:
   ```
   http://localhost:8080
   ```

---

## Estrutura do banco de dados
-Banco: ecommerce
-Tabela: produtos
  - id (INT, PK, AI)
  - nome (VARCHAR)
  - descricao (TEXT)
  - preco (DECIMAL)
  - quantidade (INT)
  - imagem (VARCHAR)
    
---

## Como adicionar produtos
Você pode adicionar produtos através do formulário disponível na página /adicionar_produto.php no sistema.

---

## Autores
- GUSTAVO JUNIO FERREIRA RODRIGUES | gustavo.2149337@discente.uemg.br
- KAUAN ALEXANDRE DIAS SILVA | kauan.2148893@discente.uemg.br
- SANTIAGO PAIVA ROSA BORGES | santiago.2148900@discente.uemg.br
- THIAGO ALVES RAMOS OLIVEIRA | thiago.2198859@discente.uemg.br
