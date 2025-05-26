# Laravel Projekt

Tento projekt je postavený na frameworku Laravel a obsahuje vlastný artisan príkaz pre jednoduché spustenie všetkých potrebných krokov pre uvedenie aplikácie do prevádzky.

## ✅ Rýchly štart

### 1. Klonovanie repozitára

```bash
# 1. Klonovanie repozitár
git clone https://github.com/Milanator/book-rental.git
cd book-rental

# 2. Súbor s env. premennými
cp .env.example .env

# 3. Inštalácia composer balíčkov
composer install

# 4. NPM, Migrácie, Seed databázy
php artisan app:setup
