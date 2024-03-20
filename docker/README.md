
# Docker

Estrutura da aplicação: Note que a maioria dos containers dependem do MySQL por causa das migrations.

Quando o app subir, o `./init.sh` rodará as migrations, e por isso o MySQL precisa estar no ar e rodando.

## [Contianers]()

- [MySQL]() - Banco da aplicação
- [APP]() - API.
- [Redis]() - Banco responsável pelo gerenciamento dos jobs.
- [Redis Commander]() - UI para gerenciar o Redis.
- [NGINX]() - Acesso à API
- [app-queue-worker]() - Container só para gerenciar a fila do Laravel.