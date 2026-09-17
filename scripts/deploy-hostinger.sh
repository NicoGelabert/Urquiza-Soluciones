#!/usr/bin/env bash
set -euo pipefail

# Ejecutar desde la raíz del proyecto en el servidor Hostinger (SSH).
# Uso: bash scripts/deploy-hostinger.sh

echo "→ Instalando dependencias PHP..."
composer install --no-dev --optimize-autoloader

echo "→ Compilando assets..."
npm ci
npm run build

echo "→ Migraciones..."
php artisan migrate --force

echo "→ Enlace storage..."
php artisan storage:link 2>/dev/null || true

echo "→ Cache de producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✓ Deploy completado."
