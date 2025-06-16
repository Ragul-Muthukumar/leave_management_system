
---

## 🛠️ Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL
- Laravel CLI
- Vue CLI or Vite

---

## 🔧 Setup Instructions

### Backend (Laravel)

```bash
cd leave-management-system

# Install PHP dependencies
composer install

# Setup environment file
cp .env.example .env
php artisan key:generate

# Setup DB credentials in .env
# Run migrations
php artisan migrate --seed

# Start Laravel server
php artisan serve
