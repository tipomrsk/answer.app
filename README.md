# [answer.app]()

Essa aplicação é uma API que pode ser usada para a criação de um formulário de perguntas e responder. Ela é bem simples, nada de muito rebuscado ou complicado para ler e entender.


## [Pacotes]()

Esses foram os pacotes Instalados a mais fora o próprio Laravel.

- [Spatie/Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction)
- [Spatie/Laravel Webhook Server](https://github.com/spatie/laravel-webhook-server)
- [Predis](https://github.com/predis/predis)
- [Pest](https://pestphp.com/)


## [Documentação da API]()

Além da Collection do Postman e do Pest, tem aqui também essa documentação da API mais simples.

### Formulário

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




## 🚀 Sobre mim
Dev fullstack, dos brabo, pra mim não tem tempo ruim kkkk'


## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://github.com/tipomrsk)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/tipomrsk)
[![instagram](https://img.shields.io/badge/instagram-1DA1F2?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/tipomrsk)

