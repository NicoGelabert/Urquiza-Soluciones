# Deploy en Hostinger — Urquiza Soluciones

## Requisitos del hosting

- PHP **8.3+** (extensiones: `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `bcmath`)
- MySQL 8+
- Composer disponible (SSH o terminal de hPanel)
- Node.js 20+ para compilar assets (en servidor o en local antes de subir)
- Document root apuntando a la carpeta **`public/`** del proyecto

## 1. Repositorio GitHub

```bash
git add -A
git commit -m "Sitio nuevo Laravel + Inertia"
git remote add origin https://github.com/TU_USUARIO/urquizasoluciones.git
git push -u origin master
```

Si el repo ya existe y querés reemplazarlo:

```bash
git push -u origin master --force
```

> Solo usar `--force` cuando estés seguro de sobrescribir el sitio anterior.

## 2. Base de datos (hPanel)

1. **Bases de datos MySQL** → crear BD y usuario
2. Anotar: host, nombre BD, usuario, contraseña

## 3. Subir el código

### Opción A — Git (recomendada)

En Hostinger → **Avanzado → Git** → clonar el repo en `domains/urquizasoluciones.es/` (o la ruta que use tu plan).

### Opción B — SSH

```bash
cd ~/domains/urquizasoluciones.es
git clone https://github.com/TU_USUARIO/urquizasoluciones.git .
```

## 4. Configurar `.env` de producción

Copiar `.env.production.example` a `.env` y completar:

| Variable | Valor |
|----------|-------|
| `APP_URL` | `https://www.urquizasoluciones.es` |
| `APP_DEBUG` | `false` |
| `DB_*` | credenciales de hPanel |
| `MAIL_*` | SMTP de Hostinger (o el que uses) |
| `ADMIN_*` | contraseñas fuertes (no las de desarrollo) |
| Analytics / reCAPTCHA | IDs de producción |

Generar clave de aplicación:

```bash
php artisan key:generate
```

## 5. Instalar dependencias y compilar

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force --seed   # solo la primera vez
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Permisos (si hace falta):

```bash
chmod -R 775 storage bootstrap/cache
```

## 6. Document root

En hPanel → **Dominios** → `urquizasoluciones.es` → **Document root**:

```
/home/USER/domains/urquizasoluciones.es/public_html/public
```

(Ajustar ruta según dónde clonaste el repo. Lo importante: que apunte a **`public/`**.)

## 7. Cola de emails (cron)

Los formularios envían mail en cola. En hPanel → **Cron Jobs**:

```
* * * * * cd /ruta/al/proyecto && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

Alternativa sin cron: cambiar `QUEUE_CONNECTION=sync` en `.env` (emails síncronos, más simple pero más lento).

## 8. reCAPTCHA y dominios

En [Google reCAPTCHA Admin](https://www.google.com/recaptcha/admin), añadir:

- `urquizasoluciones.es`
- `www.urquizasoluciones.es`

## Error: `Unable to locate file in Vite manifest: resources/css/app.css`

Significa que **no se compiló el frontend** en el servidor (falta `public/build/manifest.json`) o el código desplegado no es el último del repo.

Por SSH, en la raíz del proyecto:

```bash
cd /home/u324271993/domains/urquizasoluciones.es
git pull origin main
npm ci
npm run build
php artisan view:clear
php artisan config:clear
```

Comprobá que exista el manifest:

```bash
ls -la public/build/manifest.json
```

Verificá que el layout sea el nuevo (solo `resources/views/app.blade.php`, **sin** `resources/views/layouts/app.blade.php`):

```bash
grep rootView app/Http/Middleware/HandleInertiaRequests.php
ls resources/views/
```

`rootView` debe ser `'app'`. Si ves `layouts/app.blade.php`, borrá archivos del sitio viejo y volvé a clonar el repo.

## 9. Verificación post-deploy

- [ ] Home ES e EN cargan
- [ ] `/login` admin funciona
- [ ] Formulario contacto envía mail
- [ ] Formulario presupuesto envía mail
- [ ] Banner de cookies + GA4 + Clarity
- [ ] Imágenes subidas desde admin (`storage/app/public`)
- [ ] HTTPS activo (Let's Encrypt en hPanel)

## 10. Sustituir el sitio viejo

1. Hacer backup del repo y BD actuales en Hostinger
2. Desplegar el nuevo sitio (pasos anteriores)
3. Probar con dominio o subdominio de prueba si Hostinger lo permite
4. Cuando todo esté OK, el dominio principal ya apunta al nuevo `public/`

## Actualizaciones futuras (sin Node en el servidor)

### Cambios de CSS / Vue / JS

```bash
# 1. Local
npm run build
git add .
git commit -m "..."
git push origin master:main

# 2. SSH (código PHP/Vue fuente)
cd /home/u324271993/domains/urquizasoluciones.es
git pull origin main

# 3. FTP / File Manager — subir carpeta public/build/ completa

# 4. SSH (opcional)
/opt/alt/php83/usr/bin/php artisan view:clear
```

### Solo cambios PHP (sin tocar estilos)

```bash
git push origin master:main          # local
git pull origin main                 # SSH
/opt/alt/php83/usr/bin/php artisan migrate --force   # si hay migraciones
/opt/alt/php83/usr/bin/php artisan config:cache
/opt/alt/php83/usr/bin/php artisan route:cache
/opt/alt/php83/usr/bin/php artisan view:cache
```
