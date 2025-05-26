### Kroky pre nastavenie projektu

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
