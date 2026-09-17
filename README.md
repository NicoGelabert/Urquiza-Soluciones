# Urquiza Soluciones

Sitio web corporativo para servicios de climatización, electricidad y fontanería en la Costa del Sol.

## Stack

- Laravel 13 + Breeze (auth)
- Inertia.js + Vue 3 + TypeScript + Tailwind CSS
- Pinia (admin) + vue-i18n (ES/EN)

## Requisitos

- PHP 8.3+
- Composer
- Node.js 20+
- MySQL (Laragon) o SQLite para desarrollo rápido

## Instalación local (Laragon)

```bash
cd C:\laragon\www\urquizasoluciones
composer install
cp .env.example .env
php artisan key:generate
# Crear BD MySQL: urquizasoluciones
php artisan migrate --seed
php artisan storage:link
npm install
npm run dev
```

Configurar virtual host `urquizasoluciones.test` apuntando a `public/`.

## Acceso admin

- URL: `/login`
- Registro deshabilitado
- Credenciales por defecto (cambiar en `.env`):
  - `ADMIN_EMAIL` / `ADMIN_PASSWORD`
  - `ADMIN2_EMAIL` / `ADMIN2_PASSWORD`

## Estructura principal

| Entidad | Descripción |
|---------|-------------|
| Servicio | Aires, Electricidad, Fontanería |
| Faq | Preguntas por servicio |
| PaginaContenido | Bloques editables (home, sobre nosotros, zona…) |
| PaginaLegal | Aviso legal, privacidad, cookies |
| Solicitud | Formularios contacto/presupuesto |
| Configuracion | Teléfono, WhatsApp, email |

## Idiomas

- Español: `/`, `/servicios/{slug}`
- Inglés: `/en`, `/en/services/{slug}`

## Despliegue (Hostinger)

Guía detallada: [docs/deploy-hostinger.md](docs/deploy-hostinger.md)

Resumen por SSH:

```bash
git clone https://github.com/NicoGelabert/Urquiza-Soluciones.git .
cp .env.production.example .env   # completar valores
php artisan key:generate
bash scripts/deploy-hostinger.sh
php artisan migrate --force --seed   # solo primera vez
```

Document root del dominio → carpeta **`public/`**.

Cron (emails en cola): `* * * * * cd /ruta/proyecto && php artisan queue:work --stop-when-empty`

## Fases

- [x] Fase 1: Proyecto base, modelos, seeders, web pública básica
- [x] Fase 2: Admin CRUD, formularios contacto/presupuesto, emails, legal público
- [x] Fase 3: Diseño público, slider, componentes UI
- [ ] Fase 4: Deploy Hostinger (repo en GitHub listo; falta configurar servidor)
