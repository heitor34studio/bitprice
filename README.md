
![bitprice](https://github.com/user-attachments/assets/8d1c1b29-204f-44b2-91bb-94cb09dd88a4)

# BitPrice
![PHP Badge](https://img.shields.io/badge/PHP-6c69f5?style=for-the-badge&logo=PHP&logoColor=white) ![Guzzle Badge](https://img.shields.io/badge/Guzzle-49ccc1?style=for-the-badge&logo=Guzzle&logoColor=white) ![CSS Badge](https://img.shields.io/badge/Css-0095ff?style=for-the-badge&logo=CSS3&logoColor=white) ![JS Badge](https://img.shields.io/badge/Javascript-fff200?style=for-the-badge&logo=Javascript&logoColor=black) ![JQuery Badge](https://img.shields.io/badge/JQuery-1f48b8?style=for-the-badge&logo=JQuery&logoColor=black) ![HTML Badge](https://img.shields.io/badge/HTML-ff6600?style=for-the-badge&logo=HTML5&logoColor=black)

O projeto [BitPrice](https://heitordutra.infinityfreeapp.com/bitprice/) é uma plataforma que retorna o valor de criptomoedas da api de corretoras online e exibe em sua tela. Os limites são: 1 moeda escolhida = poder escolher todas corretoras; 2 moedas = máximo de 10 corretoras; 3 ~ 5 moedas = máximo de 5 corretoras. Neste projeto implementei funções novas como: Composer, Guzzle e estava começando a usar um pouco de POO.

###### Esse projeto foi feito numa época em que eu ainda não havia entrado na faculdade para aprender sobre: Design Patterns, SOLID, Gof, GRASP, CRUD, Estrutura de Dados, ou Modelagem de Banco de Dados, entre outros. Então foi feito meio que de qualquer jeito essa parte da Estruturação, e o que eu estava mais focando era em fazer códigos funcionarem, já que era um dos meus primeiros projetos.

## Índice 

* [Título e Descrição](#pesquisa-fipe)
* [Índice](#índice)
* [Funcionalidades do Projeto](#-funcionalidades-do-projeto)
* [Tecnologias Utilizadas](#%EF%B8%8F-técnicas-e-tecnologias-utilizadas)
* [Acesso ao Projeto](#-acesso-ao-projeto)
* [Abrir e Rodar o Projeto](#%EF%B8%8F-abrir-e-rodar-o-projeto)
* [Detalhamento do Código](#-detalhamento-do-código)

## 🔨 Funcionalidades do projeto

O BitPrice oferece as seguintes funcionalidades:

- Seleção de 5 criptomoedas principais para consulta: BITCOIN, ETHEREUM, YFI, XRP, SOL.
- Seleção de 18 corretoras diferentes para consulta: BINANCE, BITSO, NOVADAX, MERCADOBITCOIN, FOXBIT, OKX, RIPIOTRADE, BITPRECO, COINEX, KUCOIN, BITNUVEM, MEXC, BYBIT, BITSTAMP, BITFINEX, CRYPTO.COM, HUOBI, KRAKEN.
- Requisita o atual preço de X criptomoedas em Y corretoras, pela API das corretoras, e exibe os valores na tela.

## ✔️ Técnicas e tecnologias utilizadas

- `PHP`: Linguagem principal utilizada no desenvolvimento do projeto.
- `COMPOSER & GUZZLE`: Ferramentas que cuidam enviar a requisição HTTP  para as APIs.
- `CSS`: Estilização das interfaces e responsividade para diferentes dispositivos.
- `JS & JQuery`: Utilizado para fazer a comunicação com o backend.
- `HTML`: Linguagem de marcação para estruturação das páginas.

## 📁 Acesso ao projeto

Você pode ver o projeto funcionando [aqui](https://heitordutra.infinityfreeapp.com/bitprice/).

## 🛠️ Abrir e rodar o projeto

Para abrir e rodar o projeto, siga os seguintes passos:

1. Baixe o xampp e clone o repositório na pasta `htdocs`.

2. Acesse `http://localhost/`.

### Detalhamento do código:

O código PHP fornecido implementa um programa que pesquisa retorna o valor de criptomoedas da API de corretoras online e exibe na tela do usuário.

#### index.html
Arquivo que serve de interface, como as páginas acessadas pelo usuário para interagir com a aplicação. Exibe as opções de criptomoedas e corretoras a serem selecionadas pelo usuário.

#### js/*, script.js
Arquivos que contém scripts e funções para funcionamento do site, e comunicação do front-end com back-end, fazendo requisições via AJAX para o back-end, ew também cuidando de animações de desabilitação do limite de moedas para que a utilização do usuário seja mais coerente.

#### backend/controller/BuscaApiController.php
Arquivo encarregado de receber os valores enviados pelo script.js, conferir se todos são valores aceitáveis e não foram manipulados, e então faz a pesquisa manda o serviço executar. Ao receber a resposta, em um laço de repetição, imprime os valores.

#### backend/service/BuscaApiService.php e /lib/apis.php
Arquivos que contém scripts e funções para fazer a requisição para as APIs de cada corretora solicitada, e tratando dos dados retornados de forma única já que todos vêm em sintaxes diferentes. Então em um laço de repetição retornam os valores para o controller.

###### Esse projeto foi feito numa época em que eu ainda não havia entrado na faculdade para aprender sobre: Design Patterns, SOLID, Gof, GRASP, CRUD, Estrutura de Dados, ou Modelagem de Banco de Dados, entre outros. Então foi feito meio que de qualquer jeito essa parte da Estruturação, e o que eu estava mais focando era em fazer códigos funcionarem, já que era um dos meus primeiros projetos.

### Exemplo de Uso
Ao executar o programa, o usuário pode selecionar na barra lateral esquerda suas moedas de preferência, tanto como suas corretoras. Então ele clica em pesquisar e o programa exibe na tela os valores retornados das APIs das corretoras.


https://github.com/user-attachments/assets/ccd56fb5-ee32-4c94-9182-88bc0fb4f2ff


---

Este é o README atualizado para o projeto BitPrice. Ele fornece uma visão geral do projeto, suas funcionalidades, tecnologias utilizadas e como acessar e rodar o projeto. Para mais detalhes, você pode explorar os arquivos do código fonte mencionados.
