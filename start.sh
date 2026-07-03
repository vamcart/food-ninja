#!/usr/bin/env bash
set -euo pipefail
# Check if containers are already running; start only if needed
if ! docker ps --filter "name=blog_webserver" --format '{{.Names}}' | grep -q laravel-app-php || \
   ! docker ps --filter "name=blog_database" --format '{{.Names}}' | grep -q laravel-app-nginx; then
  printf "\nStarting Docker Compose...\n"
  docker compose up -d
else
  printf "\nContainers already running, skipping docker compose.\n"
fi

# Wait for containers to be healthy/running
printf "\nWaiting for containers to start...\n"
for i in {1..30}; do
  if docker ps --filter "status=running" | grep -q "laravel-app-php" && \
     docker ps --filter "status=running" | grep -q "laravel-app-nginx"; then
    printf "Containers are running.\n"
    break
  fi
  sleep 2
done

# Install Composer dependencies inside webserver container
printf "\nInstalling Composer dependencies...\n"
docker exec -it laravel-app-php composer install --no-interaction --prefer-dist

# Copy .env
printf "\nCopying .env...\n"
cp ./src/.env.example ./src/.env

# Generate Laravel key
printf "\nGenerate Laravel Key...\n"
docker exec -it laravel-app-php php artisan key:generate

# Start Migrations
printf "\nStart migrations...\n"
docker exec -it laravel-app-php php artisan key:generate

# Set permissions
printf "\nSetting folder permissions...\n"
chmod -R 777 ./src/storage
chmod -R 777 ./src/database
chmod -R 777 ./src/database/database.sqlite

printf "\nAll tasks completed successfully.\n"
printf "\n"
printf "\nOpen http://localhost:8001 in your browser.\n"