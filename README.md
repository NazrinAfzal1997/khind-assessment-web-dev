# Laravel Project Setup

## 1. Clone the Repository
```bash
git clone https://github.com/your-username/your-laravel-project.git
cd your-laravel-project
```

## 2. Install Dependencies
```bash
composer install
```

## 3. Set Up Environment File
```bash
cp .env.example .env
```

## 4. Generate Application Key
```bash
php artisan key:generate
```

## 5. Configure Database
Edit the `.env` file and update the database credentials:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 6. Run Migrations and Seed Data
```bash
php artisan migrate --seed
```

## 7. Install Frontend Dependencies (If Needed)
If the project uses Vite:
```bash
npm install
npm run dev
```
If using Laravel Mix:
```bash
npm run build
```

## 8. Start the Development Server
```bash
php artisan serve
```
Application will be available at: `http://127.0.0.1:8000`

---
Now your Laravel project is ready to use! 🚀
