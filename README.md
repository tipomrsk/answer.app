
# answer.app

API para gerenciamento de questionários.

## [Criado com:]()

![laravel](https://img.shields.io/badge/laravel-f22c2c?style=for-the-badge&logo=laravel&logoColor=white)
![docker](https://img.shields.io/badge/docker-17a1eb?style=for-the-badge&logo=docker&logoColor=white)
![mysql](https://img.shields.io/badge/mysql-00758f?style=for-the-badge&logo=mysql&logoColor=white)
![redis](https://img.shields.io/badge/redis-d82c20?style=for-the-badge&logo=redis&logoColor=white)
![nginx](https://img.shields.io/badge/nginx-009639?style=for-the-badge&logo=nginx&logoColor=white)
![php](https://img.shields.io/badge/php-777bb4?style=for-the-badge&logo=php&logoColor=white)


## [Deploy]()

Para fazer deploy do projeto você tem 3 opções

```bash
  sudo bash stack-deploy.sh
```

Esse script atualizará as dependências da maquina, instalará os pacotes necessários, removerá resíduos do docker e iniciará o projeto.

```bash
docker-compose -f ./docker/docker-compose.yaml up
```
Você subirá somente a dockerização da aplicação.

```bash
php artisan serve #E derivados
```

Aqui você subirá manualmente a aplicação, você não pode esquecer de:
- Instalar as dependências com composer.
- Rodar as migrations, seeders e o comando `sid` (mais explicações sobre no README.md do app)
  Esse comandos todos estão abstraídos dentro do DockerFile e init.sh. 

