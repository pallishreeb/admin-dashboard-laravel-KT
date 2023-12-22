Laravel Admin Dashboard

Prerequisites
Valet configuration
Mysql Database Create

step 1 - create a new laravel project
laravel new project_name

step 2- link the project to valet to run
valet link

step 3 - Make migrations for your tables and update the file
Ex - command
php artisan make:migration create_table_name
php artisan migrate

step 4 - Make model for your table and update the model
ex - command
php artisan make:model ModelName

step 5 - Make controller and update the controller with business logic
ex - command
php artisan make:controller ControllerName

step 6- Define routes for specific controllers 
ex - command
Route::get('/example', [ControllerName::class, 'methodName']);

step 7- Create view files with blade template
ex - index.blade.php

step 8 - If you want to update any table with new columns, then 

create a new migreation
ex - command
php artisan make:migration update_table_name

Migrate the changes to database
ex- command
php artisan migrate

Update the model for that table and added appropriate methods and and edit fillable if needed
App/Models/file.php