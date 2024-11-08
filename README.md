# Progetto Laravel con Docker

Questo progetto utilizza Docker per configurare un ambiente di sviluppo per Laravel, includendo i servizi PHP, MySQL e Nginx.

## Prerequisiti

Assicurati di avere installati i seguenti strumenti:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configurazione del progetto
1. copiare il file .env.example in .env

1. **Costruisci e avvia i container** :

   ```bash
   docker-compose up -d --build
   docker-compose run --rm app php artisan key:generate
   docker-compose run --rm app php artisan migrate
   docker-compose run --rm app php artisan db:seed


# Esegui i test di PHPUnit
docker compose run --rm app phpunit

# Comandi utili

    docker-compose run --rm app php artisan cache:clear
    docker-compose run --rm app php artisan config:clear
    docker-compose run --rm app php artisan route:clear
    docker-compose run --rm app php artisan view:clear

# Accesso all'applicazione

    http://localhost
