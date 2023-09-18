# Projeto de Compras de Bebidas em Laravel

Este é um projeto de exemplo para um aplicativo de compras de bebidas desenvolvido em Laravel. O aplicativo permite que os usuários naveguem por produtos, adicionem itens a um carrinho de compras, concluam pedidos e façam o checkout. Este README fornece uma visão geral das principais funcionalidades e estrutura do projeto.

## Tabela de Conteúdos

1. [Requisitos](#requisitos)
2. [Instalação](#instalação)
3. [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
4. [Fluxo do Aplicativo](#fluxo-do-aplicativo)
5. [API Endpoints](#api-endpoints)
6. [Sincronização Carrinho-Pedido](#sincronização-carrinho-pedido)
7. [Contribuindo](#contribuindo)
8. [Licença](#licença)

## Requisitos

- PHP >= 8.1
- Laravel >= 9.x
- Banco de Dados MySQL
- Composer

## Instalação

1. Clone o repositório:

   ```bash
   docker-compose up -d
   ```

## Estrutura do Banco de Dados

O projeto utiliza o Laravel Eloquent ORM para gerenciar o banco de dados. A estrutura do banco de dados é definida nas migrações localizadas em database/migrations. As principais tabelas do banco de dados são:

 * usuarios: Armazena informações dos usuários/clientes.
 * produtos: Contém detalhes dos produtos disponíveis.
 * carrinho_compras: Registra carrinhos de compras ativos dos usuários.
 * itens_carrinho: Associa produtos aos carrinhos de compras.
 * pedidos: Armazena informações sobre pedidos feitos pelos usuários.
 * itens_pedido: Vincula produtos a pedidos.


## Fluxo do Aplicativo
O aplicativo segue o seguinte fluxo geral:

Usuários registram-se ou fazem login em suas contas.
Eles navegam pelos produtos disponíveis e adicionam itens ao carrinho de compras.
Os itens do carrinho de compras são sincronizados com um pedido durante o processo de checkout.
Os pedidos são processados, verificados e entregues com base no status.


## API Endpoints
O aplicativo oferece uma API REST para gerenciar várias operações. As rotas da API estão definidas em routes/api.php. Exemplos de endpoints incluem:

 * POST /api/usuarios: Cria um novo usuário.
 * GET /api/produtos: Retorna a lista de todos os produtos disponíveis.
 * POST /api/carrinho-compras: Cria um novo carrinho de compras.
 * POST /api/pedidos: Cria um novo pedido com base no carrinho de compras ativo.
Consulte a documentação da API para obter mais detalhes e exemplos de uso.

## Sincronização Carrinho-Pedido
O projeto implementa um mecanismo para sincronizar o carrinho de compras com um pedido durante o checkout. Isso garante que o pedido reflita com precisão os itens do carrinho no momento do pedido. Durante o checkout, o carrinho é bloqueado para modificações e os itens são transferidos para um novo pedido.

## Contribuindo
Contribuições são bem-vindas! Sinta-se à vontade para abrir problemas, propor melhorias ou enviar solicitações de pull. Por favor, siga as diretrizes de contribuição do projeto.

## Licença
Este projeto é licenciado sob a Licença MIT.




## Principais dúvidas


 - Existe importação de produtos da sorocaba - consulta integridade na api de produtos

 - Como vai ser o fluxo com o 3DS - redirecionar microserviço getnet - tentativa

 - Fila de pedidos - ok




