# TaskBoard — PHP backend practical work

A minimal backend for a Trello-style task board. PHP 8.2+, PostgreSQL, Composer, Eloquent ORM, Monolog, migrations, AES-256-GCM encrypted static config.

## Requirements
- PHP 8.2+ with pdo_pgsql and openssl
- Composer
- PostgreSQL 14+

## Setup (Windows PowerShell)
1. Create PostgreSQL database `taskboard` (using pgAdmin or `createdb -U postgres taskboard`).
2. Run `composer install`.
3. Run `Copy-Item .env.example .env`.
4. Generate a key: `php -r "echo base64_encode(random_bytes(32)), PHP_EOL;"` and paste it into `APP_KEY` in `.env`.
5. Edit `DB_*` values in `.env`.
6. Run `php bin/migrate.php` (creates all four domain tables plus migration tracking).
7. Run `php bin/seed.php` (inserts demo records through Eloquent).
8. Run `php -S localhost:8000 -t public`.
9. Open http://localhost:8000/boards or http://localhost:8000/users.
10. Inspect `storage/logs/http.log` for method, path, status and response body.

## Migrations
- Apply: `php bin/migrate.php`
- Rollback (DROPS tables and their data): `php bin/migrate.php --rollback`

## Encrypted static config
- Generate encrypted value: `php bin/encrypt.php "my-secret"`.
- Paste the resulting `enc:...` string into `config/app.php`, for example `'api_token' => 'enc:...'`.
- Read in PHP: `\App\Support\Config::get('api_token')`.
- `APP_KEY` stays in `.env` and **must never be committed**. Preserve your key securely; losing it makes encrypted values unreadable.
- Do not commit secrets in plaintext or log request authorization credentials.

## GitHub publication
```bash
git init
git add .
git commit -m "Initial backend: Eloquent migrations Monolog config"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/taskboard-backend.git
git push -u origin main
```
Create an **empty public** repository named `taskboard-backend` in GitHub before running the last two commands. The repository is not published until you do this.

## Architecture
HTTP request -> public/index.php -> Eloquent models -> PostgreSQL; Monolog records requests and responses; Config reads static settings and decrypts encrypted values; migration CLI manages schema.

## Tables
- `users` (user_id PK, unique email, password_hash, name, timestamps)
- `boards` (board_id PK, owner_user_id FK, title, is_public, timestamps)
- `board_columns` (column_id PK, board_id FK, ordinal_position, title, color)
- `cards` (card_id PK, board_id FK, column_id FK, sort_index, title, content, color, is_archived, timestamps)

This is a **backend skeleton**, not a finished user-authentication or CRUD application. For public deployment, configure authentication, access control, HTTPS and log retention.
