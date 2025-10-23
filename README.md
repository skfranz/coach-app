## Dependencies
- PHP
- Composer (and ```composer global require laravel/installer```)
- Node.js
- Any SQL Databse (SQLite, MySQL, MariaDB, etc.)

## Installation
To install the app, do:

Navigate to the folder (cd)

Create a .env file off of .env example, changing
- DB_CONNECTION=
- DB_HOST=localhost
- DB_PORT=3306
- DB_DATABASE=
- DB_USERNAME=
- DB_PASSWORD=

based off of your local setup.

Then run ```composer install```

Then run ```npm install && run build```

Then run ```php artisan key:generate```

## Running
Run ```php artisan migrate``` or ```php artisan migrate:fresh``` to migrate the database tables.

Run ```php artisan serve``` to start the application server.

## Key Files
- database/migrations/001_01_01_000003_create_tasks_table.php
- app/Models/Task.php
- app/Http/Controllers/TaskController.php
- resources/views/taskpage.blade.php
- routes/web.php
