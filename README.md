# Meliora Admin

A Laravel-based admin panel application built with Filament for managing Ads and Ad Templates.

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL (or compatible database)

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/SimeonStoynev/MelioraAdmin.git
```

### 2. Navigate into the Project Directory
```bash
cd MelioraAdmin
```

### 3. Copy the Environment File

```bash
mv .env.example .env
```

(On Windows, use ```copy .env.example .env```)

### 4. Update Environment Variables

Open ``.env`` in your preferred text editor and update the database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meliora_admin
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Create the Local Database

Create a new MySQL database named ```meliora_admin```:

### 6. Install Dependencies

```bash
composer install
npm install
```

### 7. Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

This will create the database structure and seed roles, permissions, and test users.

### 8. Optimize the Application

Make sure that the config and routes are properly setup and optimized:

```bash
php artisan optimize
```

### 9. Build Frontend Assets

```bash
npm run build
```

### 10. Serve the Application

```bash
php artisan serve
```

Open http://localhost:8000 in your browser. (or the url:port where it is being served)

<hr>

### Testing the Application

The following test users were created with credentials:

<ul>
    <li>Super Admin: super_admin@meliora.web</li>
    <li>Admin: admin@meliora.web</li>
    <li>Editor: editor@meliora.web</li>
    <li>Viewer: viewer@meliora.web</li>
</ul>

Password for all users: pass123

Each role has different permissions as per the requirements.
<br>
Please log in to verify their respective access levels.

<hr>

### Running the Feature Tests

This will truncate your local database, and you will have to run ``php artisan db:seed`` after!

Navigate to the project root in the terminal and run:

```bash
vendor/bin/phpunit
```


<hr>

### Dev Notes

<ul>
    <li>I have used Laravel Pint to guarantee code styling consistency.</li>
    <li>With great interest, I dove deeper in the Filament features, utilizing Widgets for creating the Pie chart, adding custom notifications and some date range custom filters.</li>
    <li>Regarding the notifications, thoughts for future improvements could be chaining the ->after() callback on any of the actions to send an email for example.</li>
    <li>For testing convenience, I have created Factories and Seeders for the entities. Feel free to use them in the artisan tinker if needed.</li>
    <li>I have added Feature tests to ensure the core CRUD functionalities are working properly.</li>
</ul>

Thank you for taking your time to review my assessment!
