# [answer.app]()

Essa aplicação é uma API que pode ser usada para a criação de um formulário de perguntas e responder. Ela é bem simples, nada de muito rebuscado ou complicado para ler e entender.


## [Pacotes]()

Esses foram os pacotes Instalados a mais fora o próprio Laravel.

- [Spatie/Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction)
- [Spatie/Laravel Webhook Server](https://github.com/spatie/laravel-webhook-server)
- [Predis](https://github.com/predis/predis)
- [Pest](https://pestphp.com/)

## [Outras tecnologias]()

Tem duas coisas aqui um pouco mais específicas que utilizei nesse projeto para a dockerização que são:

[PHP-FPM]() - O PHP-FPM é um gerenciador de processos FastCGI para PHP. Ele é uma alternativa ao PHP mod, que é um módulo do Apache. O PHP-FPM é mais rápido e mais flexível.

[OpCache]() - O OpCache é um sistema de cache do fonte do PHP. Ele armazena o fonte compilado em memória, o que permite que o PHP execute mais rapidamente.

> É importante salientar que eles já estão configurados e ativos na dockerização. Se não for utilizar o docker, você pode instalar e configurar manualmente. 
> 
> Mas como os aquivos já estão aqui, configurar fica mais fácil. :D


## [Que mais?]()

Mais coisas sobre a aplicação:
1. É disparado um webhook e email quando um formulário é completamente respondido.
2. Usei Redis para gerenciar a fila, nada mais que isso.
3. Tem uma leve aplicação de DTO com o Laravel-Data.
4. É utilizado Service Repository pattern para separa as responsabilidades em camadas, fica mais fácil de ler, dar manutenção...
5. Aproveitei e apliquei uma interface entre a Service e a Repository para facilitar futuras modificações e refatorações.
6. Para o disparo de email, como é só testes utilizei o [MailTrap](https://mailtrap.io/).
7. Todos os usuários tem um limite de respostas por formulário que é agrupado pelo hash_identifier.
8. Esse contador de respostas é zerado mensalmente.


## [Documentação da API]()

Além da Collection do Postman e do Pest, tem aqui também essa documentação da API mais simples.

### 📒 Formulário

#### [Cria um novo formulário]()

```http
  POST /api/form/create
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | Nome do Formulário |
| `description` | `string` | Descrição do formulário |
| `webhook_url` | `string` | URL de uma Webhook server |
| `style` | `JSON` | Styles pro formulário |
| `user_id` | `int` | Id do Usuário |
| `questionnaire` | `array` | Array de objetos que são as perguntas |
| `questionnaire.question` | `string` | A pergunta em sí |
| `questionnaire.type` | `string` | Qual o tipo do dado que o usuário vai inputar |
| `questionnaire.options` | `array` | Opções caso seja um option |

> É esperado dentro do item `questionnaire` um array de objetos que são as perguntas.
```json
 "questionnaire": [
        {
            "question": "Qual o seu nome?",
            "type": "string",
            "options": []
        },
        {
            "question": "Quando voc\u00ea nasceu?",
            "type": "date",
            "options": []
        },
        {
            "question": "Quais as suas frutas favoritas?",
            "type": "select",
            "options": [
                "laranja",
                "pera",
                "maça",
                "manga",
                "limão",
                "banana",
                "kiwi"
            ]
        }
 ]
```

#### [Retorna o formulário e quais as perguntas do mesmo]()

```http
  GET /api/form/show/{{FORM-UUID}}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `form_uuid` | `string` | UUID do formulário |

> O UUID do formulário é retornado no `/api/form/create`

#### [Retorna todos os formulários criados pelo usuário SEM as perguntas]()

```http
  GET /api/form/list-by-user/{{USER-UUID}}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `user_uuid` | `string` | UUID do usuário |

> O UUID do usuário é retornado no `/api/user/create`

### 🖊️ Respostas

#### [Cria uma nova resposta]()

```http
  POST /api/answer/create
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `hash_identifier` | `string` | Hash identificador para identificar quem está preenchendo |
| `form_uuid` | `string` | UUID do formulário |
| `answers` | `array` | Array de objetos que são as respostas |
| `answers.question_id` | `int` | ID da resposta que está sendo respondida |
| `answers.answer` | `string` | Qual a resposta |

> É esperado dentro do item `answers` um array de objetos que são as respostas.
O question_id é retornado no `/api/form/show`
```json
     "answers": [
        {
            "question_id": 133,
            "answer": "Mateus Bougleux"
        },
        {
            "question_id": 134,
            "answer": "29/09/1997"
        },
        {
            "question_id": 135,
            "answer": "Laranja, Manga"
        },
        {
            "question_id": 136,
            "answer": "Cabeda"
        }
    ]
```
#### [Retorna todas as respostas aplicadas a um formulário]()

```http
  GET /api/answer/show/{{FORM-UUID}}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `form_uuid` | `string` | UUID do usuário |


> O retorno desse endpoint é agrupado pelo hash_identifier e ordenado pelo ID da questão.

```json
{
    "data":{
        "{{SOME-UUID}}":{
            "Question 1": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            "Question 2": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            "Question 3": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            // Todas as outras perguntas e respostas
        },
        "{{SOME-UUID}}": {
                        "Question 1": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            "Question 2": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            "Question 3": [
                {
                    "question": "...",
                    "type": "...",
                    "options": "...",
                    "answer": "...."
                },
            ],
            // Todas as outras perguntas e respostas
        }
        // Todas as outras hashs seguindo o mesmo padrão...
    }
}
```

### 🖊️ Usuário

#### [Cria um novo usuário]()

```http
  POST /api/user/create
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `nmame` | `string` | Nome do Usuário |
| `email` | `string` | Email do Usuário |
| `password` | `string` | Senha de acesso, mínimo 8 caracteres |
| `range_limit` | `int` | Limite de respostas que esse usuário pode ter por formulário |

#### [Busca os dados do usuário]()

```http
  POST /api/user/show/{{USER-UUID}}
```

> O UUID é retornado no endpoint `api/user/create`


### [Sobre o hash_identifier]()

Eu pensei nesse cara como algo que o front vai criar/gerenciar, pode ser um cookie ou algo assim. Como quem responde não precisa estar logado e é importante agrupar as respotas para futuras análises de dado, imaginei algo em que o front seja responsável por gerar. Não precisa ser também um UUID, pode ser outro hash qualquer porque o campo não está tipado para ser um UUID.

**Ah Mateus, mas e usar uma sessão do lado do back?** Até daria, mas aí ficamos relativamente travados se quisermos utilizar alguma solução de Load Balancers.
Mas na AWS, por exemplo, é possível fazer um "lock" de acesso por sessão em uma mesma máquina, então para LB tem saída, mas não sendo uma solução 100% aproeitável.

## [Seedando o Banco]()
Eu tava testando algumas coisas pra seedar o banco com mais e mais dados de maineira performática, aí pra fazer isso e não poluir o seed em sí eu criei um comando (que fica mais fácil de debugar também) que é o `php artisand sid` (Sim, o Sid da Era do Gelo kkkk'), fazendo meus testes aqui eu consegui sidar (rsrsrs) 200 forms, 1 question por form, e 10k de respostas por form (Que no montante da 2M de respostas), em menos de 1 minuto. Então acho que ta bacana. 

É um seed em lote, que ta limitado em 1000 objetos, não fiz alteração nenhuma nas configurações padrões do PHP. Então se você quiser testar mais coisa, elevar mais o limite, pode ser que você tenha que aumentar a memória do PHP, ou até mesmo o tempo de execução de scripts. Fica a vontade pra ir testando, esse comando ta bem comentado e é bem simples de entender.


## [Rodando os testes]()

Para rodar os testes, rode o seguinte comando.
Testes criados com [Pest](https://pestphp.com/). Rode os **seeders** antes dos testes.

```bash
  ./vendor/bin/pest
```


## 🚀 Sobre mim
Dev fullstack, dos brabo, pra mim não tem tempo ruim kkkk'


## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://github.com/tipomrsk)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/tipomrsk)
[![instagram](https://img.shields.io/badge/instagram-1DA1F2?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/tipomrsk)

