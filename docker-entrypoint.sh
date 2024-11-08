#!/bin/bash
# Imposta i permessi corretti per le cartelle necessarie
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Esegui il comando passato come argomento
exec "$@"
